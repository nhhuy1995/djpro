# # -*- coding: utf-8 -*-
import redis
import psutil
import subprocess
import json
from pymongo import MongoClient
from config import *
#
#	Common function
#

def addQuote(str):
	return '"' + str + '"'

def get_media_url(mediaPath):
	global appConfig
	return mediaPath.replace(appConfig['mediaDir'], appConfig['uploadUrl'])

def get_media_local(mediaPath):
	global appConfig
	return mediaPath.replace(appConfig['uploadUrl'], appConfig['mediaDir'])


def get_redis_connection():
	global redisDb
	connection = redis.StrictRedis(host= redisDb['address'], port=redisDb['port'], db=0)
	return connection

def check_process_name_running(name):
	# pythons_psutil = []
	for p in psutil.process_iter():
		try:
			if p.name() == name:
				return True
		except psutil.Error:
			return False
	return False


class VideoUtility :
	vid_file_path = ''
	
	def __init__ (self, vid_file_path):
		self.vid_file_path = vid_file_path

	def _probe(self):
	    ''' Give a json from ffprobe command line

	    @vid_file_path : The absolute (full) path of the video file, string.
	    '''
	    if self.vid_file_path == '':
	        raise Exception('Gvie ffprobe a full file path of the video')
	        return

	    command = ["ffprobe",
	            "-loglevel",  "quiet",
	            "-print_format", "json",
	             "-show_format",
	             "-show_streams",
	             self.vid_file_path
	             ]

	    pipe = subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
	    out, err = pipe.communicate()
	    return json.loads(out)
	
	def _convertTime(self, time_in_second):
		m, s = divmod(time_in_second, 60)
		h, m = divmod(m, 60)
		if h != 0.0:
			return "%d:%02d:%02d" % (h, m, s)
		else : 
			return "%02d:%02d" % (m, s)

	def getDuration(self):
	    ''' Video's duration in seconds, return a float number
	    '''
	    _json = self._probe()

	    if 'format' in _json:
	        if 'duration' in _json['format']:
	            return self._convertTime(float(_json['format']['duration']))

	    if 'streams' in _json:
	        # commonly stream 0 is the video
	        for s in _json['streams']:
	            if 'duration' in s:
	                return self._convertTime(float(s['duration']))

	    # if everything didn't happen,
	    # we got here because no single 'return' in the above happen.
	    raise Exception('I found no duration')
	    #return None

class DjMongoConnect:
	dbConfig = {}
	
	def __init__ (self, dbConfig):
		self.dbConfig = dbConfig

	def connect_mongo_db(self, dbConfig):
		if dbConfig is None:
			dbConfig = self.dbConfig
		connectionString = 'mongodb://' + dbConfig['user'] + ':' + dbConfig['password']
		connectionString +=  '@' + dbConfig['address']
		client = MongoClient(connectionString, dbConfig['port'])
		
		return client[dbConfig['database']] 
