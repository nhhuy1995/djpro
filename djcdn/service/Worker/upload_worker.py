import pika
import time
import re
import json
import os
import subprocess
import setproctitle
from multiprocessing import Process
from random import randint
from threading import Thread

from config import *
from lib import *

upload_queue_name = 'upload_video_youtube'

def command_convert(params):
	filePath = params['file_path']
	title = params['title']
	privacy = params['privacy']

	core_command = [
		'youtube-upload',
		'--title=' + title,
		'--privacy=' + privacy,
		filePath
	]
	return core_command



def callback_after_upload(result, dbConfig, params):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)
	
	regex_pattern = re.compile('(?<=watch\?v=)(.*)')
	regex_id = regex_pattern.search(result)

	in_time = str(int(time.time())) + str(randint(1000, 9999))
	if  regex_id:
		video_id = regex_id.group(0);
		db.media_queue.insert(
			{
				'_id'		: in_time,
				'at_id' 	: str(params['at_id']),
				'video_id' 	: video_id,
				'status'	: 'not_in_queue',
				'type'		: 'upload_video_youtube_success',
				'user_id'	: str(params['user_id']),
				'in_time'	: time.time()
			}
		)
		print 'Upload sucess, id: ' + video_id
	else:
		db.worker_logs.insert(
			{
				'_id'		: in_time,
				'at_id' 	: params['at_id'],
				'user_id'	: str(params['user_id']),
				'message' 	: out_text,
				'type'		: 'upload_video_youtube_error',
				'in_time'	: in_time
			}
		)
		print 'Upload error, ' + out_text
	print '\n'
	pass

def queue_upload_later(dbConfig, message):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)

	in_time = str(int(time.time())) + str(randint(1000, 9999))

	db.media_queue.insert(
		{
			'_id'		: in_time,
			'status'	: 'upload_later',
			'message'	: message
		}
	)

	pass

def upload_video_process_wrapper(redisCon, params):
	uploadProcess = Process(target = upload_video_process, args = (True, params))
	uploadProcess.daemon = True
	uploadProcess.start()
	uploadProcess.join()


def upload_video_process(redisCon, params):
	setproctitle.setproctitle(UPLOADDING_PROCESS_RUNNING)
	command = command_convert(params)
	result = subprocess.check_output(
			command,
			stderr = subprocess.STDOUT
		)
	callback_after_upload(result, dbMongoWorker, params)

def insert_video_duration(dbConfig, params):
	video_utility = VideoUtility(params['file_path'])
	video_duration = video_utility.getDuration()

	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)

	db.media.update(
		{'_id': params['at_id']},
		{
			"$set": {
				'duration': video_duration
			}
		}
	)


######################  Main function #################################

def rabbbit_callback(ch, method, properties, body):
	params = json.loads(body)
	is_uploading = check_process_name_running(UPLOADDING_PROCESS_RUNNING)
	if is_uploading:
		queue_upload_later(dbMongoWorker, body)
		ch.basic_ack(delivery_tag = method.delivery_tag)
		return

	print '\n ----------------- Upload file ------------\n'
	print 'In time: ' + time.strftime('%X %x %Z') + "\n"
	
	fileExists = os.path.isfile(params['file_path'])
	ch.basic_ack(delivery_tag = method.delivery_tag)
	if fileExists:
		insert_video_duration(dbMongo, params)
		newThread = Thread(target=upload_video_process_wrapper, args=(True, params))
		newThread.start()		
	else:
		print '\n Error -- File "' + params['file_path'].encode('utf-8').strip() + '" not exitst \n'


"""
Connect Rabbit, declare queue and callback
"""
credentials = pika.PlainCredentials(rabbitMq['user'], rabbitMq['password'])
connection = pika.BlockingConnection(
	pika.ConnectionParameters(
		rabbitMq['address'], rabbitMq['port'],
		virtual_host='/', credentials = credentials,
		socket_timeout = 1800
	)
)
channel = connection.channel()

channel.queue_declare(
	queue=upload_queue_name,
	passive=False, durable=False, exclusive=False, auto_delete=False, 
)
print(' [*] Waiting for messages. To exit press CTRL+C')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(rabbbit_callback, queue=upload_queue_name)

channel.start_consuming()