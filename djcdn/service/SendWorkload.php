<?php
use \Phalcon\Mvc\User\Component;

class SendWorkload extends Component
{

    private $_rabbitClient;
    private $_queue_name;

    public function __construct() {
        include __DIR__ . "/../vendor/autoload.php";
        include __DIR__ . '/Queue/RabbitmqSend.php';

        $this->_queue_name = 'convert_audio_quality';
        $this->_rabbitClient = new RabbitmqSend(array(
            "host" => "127.0.0.1",
            "port" => "5873",
            "username" => "guest",
            "password" => "dj.job@@",
            "vhost" => "/"
        ));
    }

    public function pushMediaToConvert($params) {
        if ($this->_rabbitClient->isConnected()) {
            $params['bitrate'] = "192k";
            $result = $this->_rabbitClient->sendMessage($this->_queue_name, $this->_setParamsToConvert($params));

            $params['bitrate'] = "320k";
            $params['type'] = 'm4a';
            $this->_rabbitClient->sendMessage($this->_queue_name, $this->_setParamsToConvert($params));
        }
    }

    protected function _setParamsToConvert($params) {
        $mediaDir = $params["mediaDir"];
        $pathInfo = pathinfo($mediaDir);
        if (!empty($params['type'])) 
            $pathInfo['extension'] = $params['type'];
        $mediaNewName = $pathInfo['dirname'] . DIRECTORY_SEPARATOR;

        $bitrate = $params['bitrate'];
        $mediaNewName .= $pathInfo['filename'] . "_" . time() . "_" . $bitrate;
        $mediaNewName .= "." . $pathInfo['extension'];
        return array(
            "mediaDir" => $mediaDir,
            "media_name" => $mediaNewName,
            "bitrate" => $bitrate,
            "atid"  => $params['atid']
        );
    }
}

