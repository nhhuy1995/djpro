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

function convertToUtf8($str)
    {
        if (!$str) return false;
        $utf8 = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
        return $str;
    }

function getSymLinkForMedia($mediaLink)
    {
        preg_match('(media/[0-9\/_]+/song)', $mediaLink, $reg_result);
        if ($reg_result) {
            $key_secret = 'DJ_SECRET';
            $prefix_folder = 'media_symb';

            $seperators = array('-', '_', '/');
            $rand_sp = $seperators[array_rand($seperators)];
            $format = join($rand_sp, array('d', 'm', 'Y'));
            $symbolName = $reg_result[0].date($format).$key_secret;
            $symbolLink = $prefix_folder . '/' . md5($symbolName);
            $mediaLink = preg_replace('(media/[0-9\/_]+/song)', $symbolLink, $mediaLink);
            return $mediaLink;
        }

        preg_match('(media/yt_dl/[a-zA-Z0-9-_]+)', $mediaLink, $reg_result);
        if ($reg_result) {
            $key_secret = 'DJ_SECRET';
            $prefix_folder = 'media_symb/yt_dl';

            $seperators = array('-', '_', '/');
            $rand_sp = $seperators[array_rand($seperators)];
            $format = join($rand_sp, array('d', 'm', 'Y'));
            $symbolName = $reg_result[0].date($format).$key_secret;
            $symbolLink = $prefix_folder . '/' . md5($symbolName);
            $mediaLink = preg_replace('(media/yt_dl/[a-zA-Z0-9-_]+)', $symbolLink, $mediaLink);
            return $mediaLink;
        }
    }
?>