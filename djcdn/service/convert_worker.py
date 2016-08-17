import pika
import time
import simplejson as json
import os
import subprocess

from pymongo import MongoClient

dbMongo = {
	'address': 'dj.pro.vn',
	'port': 27017,
	'user': 'root',
	'password': '123456$',
	'database': 'djpro'
}

rabbitMq = {
	'address': '127.0.0.1', 
	'port': 	5873,
	'user': 'guest',
	'password': 'dj.job@@',
	'queue_name': 'convert_audio_quality'
}

appConfig = {
	'mediaDir' : '/home/s2.download.stream.djscdn.com/public_html/public/media',
	'uploadUrl' : 'http://s2.download.stream.djscdn.com/media'
}

def command_convert(params):
	filePath = params['mediaDir']
	bitrate = params['bitrate']
	newFile = params['media_name']

	core_command = [
		'ffmpeg',
		'-loglevel', 'quiet',
		'-i', filePath,
		'-acodec', 'libfaac',
		'-ab', bitrate,
		'-ar', '48000', '-vn', newFile
	]
	return core_command

def get_media_url(mediaPath):
	global appConfig;
	return mediaPath.replace(appConfig['mediaDir'], appConfig['uploadUrl'])

def connect_mongo_db(dbConfig, params):
	connectionString = 'mongodb://' + dbConfig['user'] + ':' + dbConfig['password']
	connectionString +=  '@' + dbConfig['address']
	client = MongoClient(connectionString, dbConfig['port'])

	return client

def insert_media_link(dbConfig, params):
	client = connect_mongo_db(dbConfig, params)
	db = client.get_database(dbConfig['database'])

	field_name = 'media_link_' + params['bitrate']
	field_value = get_media_url(params['media_name'])

	db.media.update_one(
		{'_id': params['atid']},
		{
			"$set": {
				field_name: field_value
			}
		}
	)

	pass

def rabbbit_callback(ch, method, properties, body):
	params = json.loads(body)
	print '\n ----------------- Convert file ------------\n'
	print 'In time: ' + time.strftime('%X %x %Z') + "\n"
	fileExists = os.path.isfile(params['mediaDir'])
	if fileExists:
		command = command_convert(params)
		subprocess.call(command)
		newFileExists = os.path.isfile(params['media_name'])
		newFileExists = True
		if newFileExists:
			print '\nConvert Successfull to : ' + params['media_name'] + '\n'
			insert_media_link(dbMongo, params)
		else:
			print '\nConvert Failure to : ' + params['media_name'] + '\n'
	else:
		print '\n Error -- File "' + params['media_name'] + '" not exitst \n'

	print '\n ----------------- End convert file ------------\n'
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
	queue=rabbitMq['queue_name'],
	passive=False, durable=False, exclusive=False, auto_delete=False, 
)
print(' [*] Waiting for messages. To exit press CTRL+C')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(rabbbit_callback, queue=rabbitMq['queue_name'])

channel.start_consuming()