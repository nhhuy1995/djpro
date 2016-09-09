<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->render('index');
});

$app->get('/check', function () use ($app) {
    echo $app['view']->render('check');
});

$app->post('/check', function () use ($app) {
	echo 'Cross domain';die;
});

$app->post('/upload_media', function() use ($app) {

	$result = array(
		'status' => 404,
		'message' => 'System error. Please try again later'
	);
	try {
		if ($app->request->hasFiles()) {
			$uploadDir = $app->config->application->uploadDir;
			
			foreach ($app->request->getUploadedFiles() as $file) {
				$isAllow = false;
			    $fileParts = pathinfo($file->getName());
				$targetFolder = $uploadDir .  DIRECTORY_SEPARATOR .date("Y/m_d");
				$videoFormat = array( 'mp4', 'avi', 'mkv');
				
				if (in_array($fileParts['extension'], array('jpg', 'jpeg', 'gif', 'png'))) {
					$targetFolder .= '/picture/';
					$isAllow = true;
				}

				if (in_array($fileParts['extension'], $videoFormat)) {
					$avatarFolder = $targetFolder . '/picture/';
				}

				if (in_array($fileParts['extension'], array('mp3', 'mp4', 'avi', 'mkv'))) {
					$targetFolder .= '/song/';
					$isAllow = true;
				}


				if ($isAllow) {
					if (!file_exists($targetFolder)) {
						$mkresult = mkdir($targetFolder, 0775, true);
					}
					if (isset($avatarFolder)) {
						if (!file_exists($avatarFolder)) {
						$mkresult = mkdir($avatarFolder, 0775, true);
					}
					}
					$newFileName = preg_replace('/\s+/', '_', $fileParts['filename']);
					$newFileName .= '_' . time() . "_" . rand(1000, 9999) ;
					$newFileName = convertToUtf8($newFileName);
					$newPathFile = $targetFolder . $newFileName .'.'. $fileParts['extension'];
					$hasMoveFile = $file->moveTo($newPathFile);
					if ($hasMoveFile)  {
						if (isset($avatarFolder)) {
							$newPathAvatarFile = $avatarFolder . $newFileName .'.jpg';
							$newPathSmallAvatarFile = $avatarFolder . $newFileName .'_small.jpg';
							$commandConvert = 'ffmpeg -itsoffset -1 -i ' . escapeshellcmd($newPathFile) .' -vframes 1 ' . escapeshellcmd($newPathAvatarFile);
							system($commandConvert);
							$commandConvertSmall = 'ffmpeg -itsoffset -1 -i ' . escapeshellcmd($newPathFile) .' -vframes 1 -filter:v scale="240:135" ' . escapeshellcmd($newPathSmallAvatarFile);
							system($commandConvertSmall);
							$result['avatar'] = getMediaUrl($newPathAvatarFile);
							$result['avatar_small'] = getMediaUrl($newPathSmallAvatarFile);
						}
						$result['path'][] = getMediaUrl($newPathFile);
						$result['cmd'] = $commandConvert;
					};
				}

		    }	
		    $result['status'] = 200;
		    $result['message'] = 'Success';
		} else {
			$result['message'] = 'File Empty';
		}
    } catch( Exception $e) {
    	$result['message'] = $e->getMessage();
    }

	returnJson($result);
});


$app->post('/convert_media', function() use ($app) {
	$result = array(
		'status' => 404,
		'message' => 'System error. Please try again later'
	);
	$fileUrl = $app->request->getPost('media_url');
	$mid = $app->request->getPost('mid');
	$title = $app->request->getPost('title');
	$artist = $app->request->getPost('artist');

	if (empty($mid) || empty($filePath)) {
		$filePath = getMediaPath($fileUrl);
		if (file_exists($filePath)) {
			$jobClient = new SendWorkload();
			$jobClient->pushMediaToConvert(array(
		    	"mediaDir" => $filePath,
		        "atid" => $mid,
		        "title" => $title,
		        "artist" => $artist
		    ));
		    $result['status'] = 200;
		    $result['message'] = 'Push Success';
		} else {
			$result['message'] = 'File not exists';
		}
	}

	returnJson($result);
});


$app->post('/upload_youtupe', function() use ($app) {
	$result = array(
		'status' => 404,
		'message' => 'System error. Please try again later'
	);
	$fileUrl = $app->request->getPost('media_url');
	$title = $app->request->getPost('title');
	$mid = $app->request->getPost('mid');
	$userId = $app->request->getPost('user_id');

	if (empty($mid) || empty($filePath)) {
		$filePath = getMediaPath($fileUrl);

		if (file_exists($filePath)) {
			$jobClient = new SendWorkload();
			$jobClient->pushVideoUpload(array(
				"file_path" => $filePath,
				"title" => $title,
		        "privacy" => "unlisted",
		        "at_id" => $mid,
		        "user_id" => $userId
		    ));
		    $result['status'] = 200;
		    $result['message'] = 'Push Success';
		} else {
			$result['message'] = 'File not exists';
		}
	}

	returnJson($result);
});

$app->get('/test_upload_youtube', function() use ($app) {
	// $result = array(
	// 	'status' => 404,
	// 	'message' => 'System error. Please try again later'
	// );
	// $fileUrl = $app->request->getPost('media_url');
	// $mid = $app->request->getPost('mid');

	// if (empty($mid) || empty($filePath)) {
	// 	$filePath = getMediaPath($fileUrl);
	// 	if (file_exists($filePath)) {
			// $jobClient = new SendWorkload();
			// $jobClient->pushVideoUpload(array(
			// 	"file_path" => '/home/nhung-phat-ngon-an-tuong-tai-nhiem-ky-quoc-hoi-khoa-13-1459384747.mp4',
		 //    	"title" => "Thong diep",
		 //        "privacy" => "unlisted"
		 //    ));
		 //    $result['status'] = 200;
		 //    $result['message'] = 'Push Success';
	// 	} else {
	// 		$result['message'] = 'File not exists';
	// 	}
	// }

	returnJson($result);
});


/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});

$app->get('/download_media', function() use ($app) {
	$config = $app->config;
	$quality = $this->request->get('quality');
	$at_id = $this->request->get('id');

	$host = $config->web_database->host;
    $user = $config->web_database->username;
    $pass = $config->web_database->password;
    $port = $config->web_database->port;
    $dbname = $config->web_database->dbname;

    $mongo = new MongoClient("mongodb://$user:$pass@$host:$port");
    $cursor = $mongo->selectDB("$dbname")->media;

    $media = $cursor->findOne(array("_id" => $at_id), array($quality));
    
    if ($media) {
    	$absoluteFilePath = getMediaPath($media[$quality]);
    	if (file_exists($absoluteFilePath)) {
    		header('X-Sendfile: ' . $absoluteFilePath);
    		header('Content-Disposition: attachment; filename="' . basename($absoluteFilePath) . '"');
    	} else {
    		echo "File not Found";
    	}
    } else {
    	echo "File not Found";
    }

});