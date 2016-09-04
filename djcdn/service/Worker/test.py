# # -*- coding: utf-8 -*-
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


# def probe(vid_file_path):
#     ''' Give a json from ffprobe command line

#     @vid_file_path : The absolute (full) path of the video file, string.
#     '''
#     if type(vid_file_path) != str:
#         raise Exception('Gvie ffprobe a full file path of the video')
#         return

#     command = ["ffprobe",
#             "-loglevel",  "quiet",
#             "-print_format", "json",
#              "-show_format",
#              "-show_streams",
#              vid_file_path
#              ]

#     pipe = subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
#     out, err = pipe.communicate()
#     return json.loads(out)


# def duration(vid_file_path):
#     ''' Video's duration in seconds, return a float number
#     '''
#     _json = probe(vid_file_path)

#     if 'format' in _json:
#         if 'duration' in _json['format']:
#             return float(_json['format']['duration'])

#     if 'streams' in _json:
#         # commonly stream 0 is the video
#         for s in _json['streams']:
#             if 'duration' in s:
#                 return float(s['duration'])

#     # if everything didn't happen,
#     # we got here because no single 'return' in the above happen.
#     raise Exception('I found no duration')
#     #return None
mongo = DjMongoConnect(dbMongo)
db = mongo.connect_mongo_db(dbMongo)
media_not_has_length = db.media.find(
	{
		'duration' : {
			'$exists' : False
		}
	}
)

for elem in media_not_has_length:
	media_path = get_media_local(elem['mediaurl'])
	fileExists = os.path.isfile(media_path)
	if fileExists:
		print elem['name']
		video_utility = VideoUtility(media_path)
		video_duration = video_utility.getDuration()
		print 'duration: ' + video_utility.getDuration()
		db.media.update(
			{'_id': elem['_id']},
			{
				"$set": {
					'duration': video_duration
				}
			}
		)

	
# vid_path = "/home/djcdn/public_html/public/media/2016/07_03/song/Top_10_Tiết_mục_hay_nhất_được_nhận_nút_vàng_-_Tìm_kiếm_tài_năng_anh_quốc_2016-IsReSUaaKkc_1467536019_6627.mp4"
# video_utility = VideoUtility(vid_path)

# print video_utility.getDuration()
# m, s = divmod(time_second, 60)
# h, m = divmod(m, 60)
# if h != 0.0:
# 	print "%d:%02d:%02d" % (h, m, s)
# else : 
# 	print "%02d:%02d" % (m, s)