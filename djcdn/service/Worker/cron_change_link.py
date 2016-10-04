import re
import datetime
import os
import hashlib
from random import randint
import json as json
import sys

from config import *
from lib import *

class CronMedia:
	params = {}
	key_secret = 'DJ_SECRET'

	def __init__ (self, params):
		self.params = params	

	def changeLink(self):
		mediaDir = self.params['mediaDir']
		youtubeDir = self.params['youtubeDir']

		if not os.path.isdir(self.params['mediaSymDir']):
			os.mkdir(self.params['mediaSymDir'])

		if not os.path.isdir(self.params['youtubeSymDir']):
			os.mkdir(self.params['youtubeSymDir'])
		
		for subdir, dirs, files in os.walk(mediaDir):
			if self._isUploadDir(subdir):
				self._createSymUploadLink(subdir)
			else:
				continue

		for subdir, dirs, files in os.walk(youtubeDir):
			self._createSymYoutubeLink(subdir)

	def removeOldLink(self):
		media_dir = self.params['mediaSymDir']
		symDir = next(os.walk(media_dir))[1]
		self._removeOldSymLinkInDir(symDir, media_dir)
		
		media_dir = self.params['youtubeSymDir']
		symDir = next(os.walk(media_dir))[1]
		self._removeOldSymLinkInDir(symDir, media_dir)

	def _removeOldSymLinkInDir(self, dirs, parentPath):
		current_day = datetime.date.today().strftime('%d-%m-%Y')
		for item in dirs:
			if item != 'yt_dl':
				fullPath = os.path.join(parentPath, item)
				modification_time = os.lstat(fullPath).st_mtime
				dt_obj = datetime.datetime.fromtimestamp(modification_time)
				if(dt_obj.strftime('%d-%m-%Y') != current_day):
					if (os.path.isdir(fullPath)):
						os.unlink(fullPath)

	def _createSymUploadLink(self, subdir):
		regex_size = re.compile('(media/[0-9\/_]+/song)')
		regex_result = regex_size.search(subdir)
		if regex_result:
			newName = self._createNewName(regex_result.group(1))
			for name in newName:
				symLinkName = hashlib.md5(name).hexdigest()
				newSymDir = os.path.join(
					self.params['mediaSymDir'],
					symLinkName
				)
				if not os.path.isdir(newSymDir):
					os.symlink(subdir, newSymDir)


	def _createSymYoutubeLink(self, subdir):
		regex_size = re.compile('(media/yt_dl/[a-zA-Z0-9-_]+)')
		regex_result = regex_size.search(subdir)
		if regex_result:
			newName = self._createNewName(regex_result.group(1))
			for name in newName:
				symLinkName = hashlib.md5(name).hexdigest()
				newSymDir = os.path.join(
					self.params['youtubeSymDir'],
					symLinkName
				)
				if not os.path.isdir(newSymDir):
					os.symlink(subdir, newSymDir)

	def _createNewName(self, subdir):
		today = datetime.date.today()
		newName = [
			subdir +  today.strftime('%d-%m-%Y') + self.key_secret,
			subdir + today.strftime('%d_%m_%Y') + self.key_secret,
			subdir + today.strftime('%d/%m/%Y') + self.key_secret
		]
		return newName

	def _isUploadDir(self, subdir):
		if '/media/yt_dl' in subdir:
			return False
		if '/media/image' in subdir:
			return False
		if '/media/picture' in subdir:
			return False
		if '/song' in subdir:
			return True
		return False

configInfo = {
	'mediaDir'		: '/home/djcdn/public_html/public/media',
	'youtubeDir'	: '/home/djcdn/public_html/public/media/yt_dl/',
	'mediaSymDir'	: '/home/djcdn/public_html/public/media_symb/',
	'youtubeSymDir'	: '/home/djcdn/public_html/public/media_symb/yt_dl/',
}

cronObj = CronMedia(configInfo)

if (len(sys.argv) > 1):
	if sys.argv[1] == 'change':
		cronObj.changeLink()
	if sys.argv[1] == 'clean':
		cronObj.removeOldLink()