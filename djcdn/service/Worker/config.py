#
#  Config for all worker
#

dbMongo = {
	'address': '103.9.156.125',
	'port': 27017,
	'user': 'root',
	'password': '123456$',
	'database': 'djpro'
}

dbMongoWorker = {
	'address': '127.0.0.1',
	'port': 27017,
	'user': 'root',
	'password': '123456$',
	'database': 'worker'
}

rabbitMq = {
	'address': '127.0.0.1', 
	'port': 	5672,
	'user': 'dj_job',
	'password': 'dj.job@@'
}

appConfig = {
	'mediaDir' : '/home/djcdn/public_html/public/media',
	'uploadUrl' : 'http://s1.download.stream.djscdn.com/media'
}

redisDb = {
	'address': 'localhost',
	'port': 6379
}

IS_CONVERT_PROCESSING = 'convert_processing'
IS_UPLOAD_PROCESSING = 'upload_processing'
IS_DOWNLOAD_PROCESSING = 'download_processing'

CONVERTING_PROCESS_RUNNING = 'dj_converting_process'
UPLOADDING_PROCESS_RUNNING = 'dj_uploading_process'
DOWNLOADING_PROCESS_RUNNING = 'dj_download_process'