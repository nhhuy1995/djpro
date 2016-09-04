import pika
import time
import datetime
import json as json
import os
import subprocess
import setproctitle
from random import randint
from mutagen.mp3 import MP3
from threading import Thread
from multiprocessing import Process


from config import *
from lib import *

convert_queue_name = 'convert_audio_quality'

def command_convert(params):
	filePath = params['mediaDir']
	bitrate = params['bitrate']
	newFile = params['media_name']
	if bitrate == '35000':
		return command_m4a(params)

	if 'cutoff' in params:
		cutoff = params['cutoff']
	else:
		cutoff = '20'

	now = datetime.datetime.now()
	core_command = [
		'ffmpeg',
		'-loglevel', 'quiet',
		'-i', filePath,
		'-ab', bitrate,
		'-ar', '44100', 
		'-cutoff', cutoff,
		'-metadata', 'title=' + params['title'],
		'-metadata', 'artist=' + params['artist'],
		'-metadata', 'album=' + params['album'],
		'-metadata', 'year=' + str(now.year),
		'-metadata', 'genre=' + params['genre'],
		'-metadata', 'comment=' + params['comment'],
		'-metadata', 'composer=' + params['composer'],
		'-metadata', 'encoder=' + params['encoder'],

		'-vn', newFile
	]
	return core_command

def command_m4a(params):
	filePath = params['mediaDir']
	bitrate = params['bitrate']
	newFile = params['media_name']
	if 'cutoff' in params:
		cutoff = params['cutoff']
	else:
		cutoff = '15500'

	now = datetime.datetime.now()
	core_command = [
		'ffmpeg',
		'-loglevel', 'quiet',
		'-i', filePath,
		'-c:v',  'mpeg4',
		'-c:a', 'libfdk_aac',
		'-profile:a', 'aac_he_v2',
		'-ab', bitrate, 
		'-ar', '44100', 
		'-cutoff', cutoff,
		'-metadata', 'title=' + params['title'],
		'-metadata', 'artist=' + params['artist'],
		'-metadata', 'album=' + params['album'],
		'-metadata', 'year=' + str(now.year),
		'-metadata', 'genre=' + params['genre'],
		'-metadata', 'comment=' + params['comment'],
		'-metadata', 'composer=' + params['composer'],
		'-metadata', 'encoder=' + params['encoder'],

		'-vn', newFile
	]
	return core_command

def insert_media_link(dbConfig, params):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)

	if params['bitrate'] == '35000':
		field_name = 'media_link_32k'
	else:
		field_name = 'media_link_' + params['bitrate']
	field_value = get_media_url(params['media_name'])

	db.media.update(
		{'_id': params['atid']},
		{
			"$set": {
				field_name: field_value
			}
		}
	)

	pass

def queue_convert_later(dbConfig, message):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)

	in_time = str(int(time.time())) + str(randint(1000, 9999))

	db.media_queue.insert(
		{
			'_id'		: in_time,
			'status'	: 'convert_later',
			'message'	: message
		}
	)

	pass

def convert_video_process_wrapper(newProcess, params):
	convertProcess = Process(target = convert_audio_process, args = (newProcess, params))
	convertProcess.daemon = True
	convertProcess.start()
	convertProcess.join()


def convert_audio_process(newProcess, params):
	if newProcess:
		setproctitle.setproctitle(CONVERTING_PROCESS_RUNNING)
	print '\n ----------------- Convert file ------------\n'
	print 'In time: ' + time.strftime('%X %x %Z') + "\n"
	command = command_convert(params)
	result = subprocess.check_output(
		command,
		stderr = subprocess.STDOUT
	)

	newFileExists = os.path.isfile(params['media_name'])
	if newFileExists:
		print '\nConvert Successfull to : ' + params['media_name'].encode('utf-8').strip() + '\n'
		insert_media_link(dbMongo, params)
	else:
		print '\nConvert Failure to : ' + params['media_name'].encode('utf-8').strip() + '\n'

def rabbbit_callback(ch, method, properties, body):
	params = json.loads(body)
	is_convert = check_process_name_running(CONVERTING_PROCESS_RUNNING)
	if is_convert:
		queue_convert_later(dbMongoWorker, body)
		ch.basic_ack(delivery_tag = method.delivery_tag)
		return

	fileExists = os.path.isfile(params['mediaDir'])
	if fileExists:
		try:
			audio = MP3(params['mediaDir'])
		except Error:
			ch.basic_ack(delivery_tag = method.delivery_tag)
			return
		audioLength = int(audio.info.length)
		if audioLength > 600:
			ch.basic_ack(delivery_tag = method.delivery_tag)
			newThread = Thread(target=convert_video_process_wrapper, args=(True, params))
			newThread.start()
			return
		else:
			convert_audio_process(False, params)	
			ch.basic_ack(delivery_tag = method.delivery_tag)
	else:
		print '\n Error -- File "' + params['mediaDir'].encode('utf-8').strip() + '" not exitst \n'
		ch.basic_ack(delivery_tag = method.delivery_tag)

"""
Script to connect rabbitmq
"""
credentials = pika.PlainCredentials(rabbitMq['user'], rabbitMq['password'])
connection = pika.BlockingConnection(
	pika.ConnectionParameters(rabbitMq['address'], rabbitMq['port'], virtual_host='/', credentials = credentials)
)
channel = connection.channel()

channel.queue_declare(
	queue=convert_queue_name,
	passive=False, durable=False, exclusive=False, auto_delete=False, 
)
print(' [*] Waiting for messages. To exit press CTRL+C')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(rabbbit_callback, queue=convert_queue_name)

channel.start_consuming()