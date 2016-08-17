<?php 

function returnJson ($params) {
	header("Content-Type:application/json;charset=utf-8");
	echo json_encode($params);
	exit;
};

function getMediaUrl ($mediaDir, $uploadUrl = '', $uploadDir = '') {
	global $app;
	if (!strlen ($uploadUrl)) 
		$uploadUrl = $app->config->application->uploadMediaUrl;

	if (!strlen ($uploadDir)) 
		$uploadDir = $app->config->application->uploadDir;

	return str_replace($uploadDir, $uploadUrl, $mediaDir);
}

function getMediaPath ($mediaUrl, $uploadUrl = '', $uploadDir = '') {
	global $app;
	$mediaUrl = strval($mediaUrl);
	if (!strlen ($uploadUrl)) 
		$uploadUrl = $app->config->application->uploadMediaUrl;

	if (!strlen ($uploadDir)) 
		$uploadDir = $app->config->application->uploadDir;

	return str_replace($uploadUrl, $uploadDir, $mediaUrl);
}

?>