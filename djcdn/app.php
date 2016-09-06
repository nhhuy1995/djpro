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
					$newPathFile = $targetFolder . $newFileName .'.'. $fileParts['extension'];
					$hasMoveFile = $file->moveTo($newPathFile);
					if ($hasMoveFile)  {
						if (isset($avatarFolder)) {
							$newPathAvatarFile = $avatarFolder . $newFileName .'.jpg';
							$newPathSmallAvatarFile = $avatarFolder . $newFileName .'_small.jpg';
							$commandConvert = 'ffmpeg -itsoffset -1 -i ' . $newPathFile .' -vframes 1 " ' . $newPathAvatarFile;
							system(escapeshellcmd($commandConvert));
							$commandConvertSmall = 'ffmpeg -itsoffset -1 -i ' . $newPathFile .' -vframes 1 -filter:v scale="240:135" ' . $newPathSmallAvatarFile;
							system(escapeshellcmd($commandConvertSmall));
							$result['avatar'] = getMediaUrl($newPathAvatarFile);
							$result['avatar_small'] = getMediaUrl($newPathSmallAvatarFile);
						}
						$result['path'][] = getMediaUrl($newPathFile);
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

	if (empty($mid) || empty($filePath)) {
		$filePath = getMediaPath($fileUrl);

		if (file_exists($filePath)) {
			$jobClient = new SendWorkload();
			$jobClient->pushVideoUpload(array(
				"file_path" => $filePath,
				"title" => $title,
		        "privacy" => "unlisted",
		        "at_id" => $mid
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
