import pika
import time
from random import randint
import json as json

from config import *
from lib import *

# all available video format with type mp4
list_format_wanted = ['137+140', '22', '135+140' , '18' , '133+140' ,' 160+140']
# list_format_wanted = ['137+141', ' 160+140']

def push_upload_job(channel, dbConfig):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)
	media_not_in_queue = db.media_queue.find({
		"status" : "not_in_queue"
	})

	for elem in media_not_in_queue:
		insert_from_media_queue(elem, db)
	

	media_not_in_queue = db.worker_logs.find({
		"status" : "not_in_queue"
	})

	for elem in media_not_in_queue:
		insert_from_worker_logs(elem, db)

	channel.queue_declare(queue='upload_video_youtube')
	media_not_in_queue = db.media_queue.find({
		"status" : "upload_later"
	})

	for elem in media_not_in_queue:
		insert_upload_from_media_queue(elem, db)


############ Insert video need upload from media_queue
def insert_upload_from_media_queue(elem, db):
	result = channel.basic_publish(
		exchange='', 
		routing_key= 'upload_video_youtube',
		body=elem['message']
	)

	db.media_queue.remove({'_id': elem['_id']})

############ Insert from media_queue
def insert_from_media_queue(elem, db):
	for video_type in list_format_wanted:
		elem_id = str(int(time.time())) + str(randint(1000, 9999))
		message = {
			'_id':	str(elem_id),
			'at_id': str(elem['at_id']),
			'video_id': elem['video_id'],
			'video_type': video_type
		}
		result = channel.basic_publish(
			exchange='', 
			routing_key= 'download_video_youtube',
			body=json.dumps(message)
		)
		message['status'] = 'in_queue'
		db.worker_logs.insert(message)

	db.media_queue.remove({'_id': elem['_id']})

############ Insert from worker_logs
def insert_from_worker_logs(elem, db):
	message = {
		'_id':	elem['_id'],
		'at_id': elem['at_id'],
		'video_id': elem['video_id'],
		'video_type': elem['video_type']
	}
	result = channel.basic_publish(
		exchange='', 
		routing_key= 'download_video_youtube',
		body=json.dumps(message)
	)
	db.worker_logs.update(
		{'_id': elem['_id']},
		{
			"$set": {
				'status'	: 'in_queue'
			}
		}
	)

#----------------  Connect and push job ----------------

credentials = pika.PlainCredentials(rabbitMq['user'], rabbitMq['password'])
connection = pika.BlockingConnection(
	pika.ConnectionParameters(
		rabbitMq['address'], rabbitMq['port'],
		virtual_host='/', credentials = credentials
	)
)
channel = connection.channel()
channel.queue_declare(queue='download_video_youtube')

push_upload_job(channel, dbMongoWorker)

connection.close()