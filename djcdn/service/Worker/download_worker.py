import re
import pika
import time
import json
import os
import subprocess
from random import randint
from downloader import YoutubeDLDownloader
from threading import Thread
import setproctitle
from multiprocessing import Process

from config import *
from lib import *

download_queue_name = 'download_video_youtube'	

class DownloadWorker:
	params = {}
	core_command = [
		'-f', '160+140', 
		'-o', '%(id)s/%(title)s-_fw%(width)se_-fh%(height)se.%(ext)s'
	]
	mongo_cusor = {}
	mongo_worker_cusor = {}
	file_info = {}

	IN_PROCESSING = 'in_processing'
	NOT_PROCESS_YET = 'not_in_queue'
	ERROR_LOG = 'error_log'

	def __init__ (self, params, dbConfig = {}, dbMongoWorker = {}): 
		mongo = DjMongoConnect(dbConfig)
		
		self.params = params	
		self.dbConfig = dbConfig
		self.mongo_cusor = mongo.connect_mongo_db(dbConfig)
		self.mongo_worker_cusor = mongo.connect_mongo_db(dbMongoWorker)

	def _data_hook(self, params):
		if params['status'] == 'Downloading':
			self._assign_file_info(params)
		if params['status'] == 'Finished':
			self._insert_media_link(params)
		pass

	def _assign_file_info(self, params):
		if 'filename' in params:
			regex_size = re.compile('-_fw(\d*)e_-fh(\d*)e')
			regex_result = regex_size.search(params['filename'])
			if regex_result:
				file_path = params['path'] + '/' + params['filename'] + params['extension']
				self.file_info['type'] = regex_result.group(2)
				self.file_info['file_path'] = file_path
		pass

	def _insert_media_link(self, params):
		if 'file_path' not in self.file_info:
			return
		
		newFileExists = os.path.isfile(
			self.file_info['file_path']
		)

		if newFileExists:
			field_name = 'link_video_' + self.params['video_resolution']
			field_value = get_media_url(self.file_info['file_path']).encode('utf-8').strip()

			self.mongo_cusor.media.update(
				{'_id': self.params['at_id']},
				{
					"$set": {
						field_name: field_value
					}
				}
			)

			self.mongo_worker_cusor.worker_logs.remove(
				{'_id': self.params['_id']}
			)
			print 'Video in format: ' + self.file_info['type']
			print 'File location: ' + self.file_info['file_path'].encode('utf-8').strip()
			print 'File url:' + field_value
		else:
			print 'Download file incomplete'
		pass

	def _log_data_error(self, params):
		in_processing_alert = "ERROR: We're processing this video. Check back later."
		print '++++Error+++ \n'
		print params
		if params == in_processing_alert:
			update_detail = {
				'status'	: self.NOT_PROCESS_YET
			}
		elif 'type' in self.file_info:
			update_detail = {
				'status'	: self.NOT_PROCESS_YET
			}
		else:
			update_detail = {
				'status'	: self.ERROR_LOG,
				'message'	: params
			}

		self.mongo_worker_cusor.worker_logs.update(
			{'_id': self.params['_id']},
			{
				"$set": update_detail
			}
		)

		self._check_copyright_error(params)


		pass

	def _check_copyright_error(self, params):
		copyright_error = 'who has blocked it'
		delete_error = "This video has been removed"
		if copyright_error in params or delete_error in params:
			self.mongo_cusor.media.update(
				{'_id': self.params['at_id']},
				{
					"$set": {
						'download_video_error': 'Khong the download video do vi pham ban quyen'
					}
				}
			)
			copyright_log = self.mongo_cusor.alert_cms.find_one(
				{'at_id': self.params['at_id'], 'type': 'copyright'}
			)
			if (copyright_log == None) :
				self.mongo_cusor.alert_cms.insert(
					{
						'_id': str(int(time.time())) + str(randint(1000, 9999)),
						'at_id': self.params['at_id'],
						'user_id': self.params['user_id'],
						'type': 'copyright',
						'unread': 1,
						'time': time.time()
					}
				)
		pass


	def _check_params_valid(self):
		if 'at_id' not in self.params:
			print "Not include article's id"
			return False
		# if 'video_id' not in self.params:
		# 	print "Not include video's id"
		# 	return False

		return True

	def _get_video_url(self):
		mongo_log = self.mongo_worker_cusor.worker_logs.find_one(
			{'_id': self.params['_id']}
		)
		
		return  'https://www.youtube.com/watch?v=' + mongo_log['video_id']

	def _standard_command(self):
		self.core_command[3] = os.path.join(
			appConfig['mediaDir'],
			self.core_command[3]
		)
		self.core_command[1] = self.params['video_type']

	def _queue_download_later(self):
		update_detail = {
				'status'	: self.NOT_PROCESS_YET
			}
		self.mongo_worker_cusor.worker_logs.update(
			{'_id': self.params['_id']},
			{
				"$set": update_detail
			}
		)

		pass


	def _download_video_process_wrapper(self):
		downloadProcess = Process(target = self._download_process_in_thread, args = ())
		downloadProcess.daemon = True
		downloadProcess.start()
		downloadProcess.join()



	def _download_process_in_thread(self):
		setproctitle.setproctitle(DOWNLOADING_PROCESS_RUNNING)
		print '\n ----------------- Download file ------------\n'

		print 'In time: ' + time.strftime('%X %x %Z') + "\n"

		check_valid = self._check_params_valid()

		self._standard_command()
		downloader = YoutubeDLDownloader(
			'/usr/bin/youtube-dl',
			self._data_hook,
			self._log_data_error
		)
		video_url = self._get_video_url()
		downloader.download(video_url, self.core_command)
		print '\n \n'

	def start_process(self):
		self.redisCon = get_redis_connection()
		is_downloading = check_process_name_running(DOWNLOADING_PROCESS_RUNNING)
		if is_downloading:
			self._queue_download_later()
			return

		newThread = Thread(target=self._download_video_process_wrapper, args=())
		newThread.start()		
		
		

def rabbbit_callback(ch, method, properties, body):
	params = json.loads(body)

	worker = DownloadWorker(params, dbMongo, dbMongoWorker)

	worker.start_process()

	ch.basic_ack(delivery_tag = method.delivery_tag)



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
	queue = download_queue_name,
	passive=False, durable=False, exclusive=False, auto_delete=False, 
)
print(' [*] Waiting for messages. To exit press CTRL+C')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(rabbbit_callback, queue = download_queue_name)

channel.start_consuming()