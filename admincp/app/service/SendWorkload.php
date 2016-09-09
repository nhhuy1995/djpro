<?php
namespace DjCms\Service;

use \Phalcon\Mvc\User\Component;
use DjCms\Library\Queue\RabbitmqSend;

class SendWorkload extends Component
{

    private $_rabbitClient;
    private $_remoteUrl = 'http://s1.download.stream.djscdn.com/convert_media';
    private $_uploadVideoUrl = 'http://s1.download.stream.djscdn.com/upload_youtupe';

    public function __construct() {
//        include __DIR__ . "/../../vendor/autoload.php";
//        $this->_rabbitClient = new RabbitmqSend(array(
//            "host" => "127.0.0.1",
//            "port" => "5672",
//            "username" => "guest",
//            "password" => "guest",
//            "vhost" => "/"
//        ));

    }

    public function pushMediaToConvert($params) {
        $server_output = false;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_remoteUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        if (!empty($params['media_url']) && $params['mid']) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec ($ch);

            curl_close ($ch);
        }
        return $server_output;
//        if ($this->_rabbitClient->isConnected()) {
//            $params['bitrate'] = "128k";
//            $this->_rabbitClient->sendMessage("convert_audio_quality", $this->_setParamsToConvert($params));
//
//            $params['bitrate'] = "192k";
//            $this->_rabbitClient->sendMessage("convert_audio_quality", $this->_setParamsToConvert($params));
//        }
    }

    public function pushVideoToYoutube($params) {

        $defaultParams = array(
            "media_url" => "",
            "title" => "Title",
            "privacy" => "unlisted",
            "user_id" => "0"
        );
        $params = array_merge($defaultParams, $params);
        $server_output = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_uploadVideoUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        if (!empty($params['media_url']) && $params['mid']) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec ($ch);

            curl_close ($ch);
        }
        
        return $server_output;
//        if ($this->_rabbitClient->isConnected()) {
//            $params['bitrate'] = "128k";
//            $this->_rabbitClient->sendMessage("convert_audio_quality", $this->_setParamsToConvert($params));
//
//            $params['bitrate'] = "192k";
//            $this->_rabbitClient->sendMessage("convert_audio_quality", $this->_setParamsToConvert($params));
//        }
    }

    protected function _setParamsToConvert($params) {
        $mediaUrl = $params["mediaurl"];
        $pathInfo = pathinfo($mediaUrl);
        $mediaNewName = $pathInfo['dirname'] . DIRECTORY_SEPARATOR;

        $bitrate = $params['bitrate'];
        $mediaNewName .= $pathInfo['filename'] . "_" . time() . "_" . $bitrate;
        $mediaNewName .= "." . $pathInfo['extension'];
        return array(
            "mediaurl" => $mediaUrl,
            "medianame" => $mediaNewName,
            "bitrate" => $bitrate,
            "atid"  => $params['atid']
        );
    }
}

