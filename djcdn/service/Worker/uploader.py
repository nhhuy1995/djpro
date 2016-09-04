import re
from downloader import YoutubeDLDownloader

class DownloadWorker(object):
	params = {}
	core_command = [
		# '-f', '137+141,22,135+140,18,133+140',
		'-f', '133+140',
		'-o', '/home/saasbook/Videos/temp_folder/%(title)s-_fw%(width)se_-fh%(height)se.%(ext)s'
	]
	mongo_cusor = {}
	
	IN_PROCESSING = 'in_processing'
	NOT_PROCESS_YET = 'not_in_queue'
	ERROR_LOG = 'error_log'

	def __init__ (self, params, dbConfig = {}): 
		# mongo = DjMongoConnect()
		
		self.params = params	
		self.dbConfig = dbConfig
		# self.mongo_cusor = mongo.connect_mongo_db(dbConfig)

	def _data_hook(self, params):
		print params
		# if params['status'] == 'Downloading':
		# 	self._insert_media_link(params)
		# if params['status'] == 'Finished':
		# 	print 'Download Finish'
		pass

	def _insert_media_link(self, params):
		if 'filename' in params:
			file_path = params['path'] + '/' + params['filename'] + params['extension']
			# file_url = get_media_url(file_path)
			regex_size = re.compile('-_fw(\d*)e_-fh(\d*)e')
			regex_result = regex_size.search(params['filename'])
			if regex_result:
				print regex_result.group(2)
			# print file_path
		pass

	def _log_data_error(self, params):
		in_processing_alert = "ERROR: We're processing this video. Check back later."

		if params == in_processing_alert:
			update_detail = {
				'status'	: self.NOT_PROCESS_YET
			}
		else:
			update_detail = {
				'status'	: self.ERROR_LOG,
				'message'	: params
			}
		print params
		# self.mongo_cusor.worker_logs.update_one(
		# 	{'_id': self.params['_id']},
		# 	{
		# 		"$set": update_detail
		# 	}
		# )

		pass

	def start_process(self):
		# self.mongo_cusor.worker_logs.update_one(
		# 	{'_id': self.params['_id']},
		# 	{
		# 		'status'	: self.IN_PROCESSING,
		# 	}
		# )

		downloader = YoutubeDLDownloader(
			'/usr/local/bin/youtube-dl',
			self._data_hook,
			self._log_data_error
		)
		downloader.download(self.params['video_url'], self.core_command)

downloader = DownloadWorker({
	'video_url': 'https://www.youtube.com/watch?v=Vj13mfrP68o'
})
downloader.start_process()