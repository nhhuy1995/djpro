import pika
import time
from random import randint
from pymongo import MongoClient
import json as json

from config import *
from lib import *

def push_upload_job(channel, dbConfig):
	mongo = DjMongoConnect(dbConfig)
	db = mongo.connect_mongo_db(dbConfig)
	media_not_in_queue = db.media_queue.find({
		"status" : "convert_later"
	})

	print 'Cron job audio'
	for elem in media_not_in_queue:
		insert_from_media_queue(elem, db)


############ Insert from media_queue
def insert_from_media_queue(elem, db):
	result = channel.basic_publish(
		exchange='', 
		routing_key= 'convert_audio_quality',
		body=elem['message']
	)

	db.media_queue.remove({'_id': elem['_id']})

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