<?php
use \Phalcon\Mvc\User\Component;

class SendWorkload extends Component
{

    private $_rabbitClient;
    private $_queue_name;
    private $_upload_queue_name;
    private $_common_infor = 'www.dj.pro.vn';

    public function __construct() {
        include __DIR__ . "/../vendor/autoload.php";
        include __DIR__ . '/Queue/RabbitmqSend.php';

        $this->_queue_name = 'convert_audio_quality';
        $this->_upload_queue_name = 'upload_video_youtube';
        
        $this->_rabbitClient = new RabbitmqSend(array(
            "host" => "127.0.0.1",
            "port" => "5672",
            "username" => "dj_job",
            "password" => "dj.job@@",
            "vhost" => "/"
        ));
    }

    public function pushMediaToConvert($params) {
        if ($this->_rabbitClient->isConnected()) {
            $params['bitrate'] = "128k";
            $params['cutoff'] = "16k";
            $result = $this->_rabbitClient->sendMessage($this->_queue_name, $this->_setParamsToConvert($params));

            $params['bitrate'] = "64k";
            $params['cutoff'] = "16k";
            $this->_rabbitClient->sendMessage($this->_queue_name, $this->_setParamsToConvert($params));

            $params['bitrate'] = "320k";
            $params['cutoff'] = "20k";
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
        $mediaNewName .= $pathInfo['filename'] . "_[" . strtoupper($pathInfo['extension']) ."_" . $bitrate . "]";
        // $mediaNewName .= "." . $pathInfo['extension'];
        $mediaNewName .= "." . 'mp3';
        $commonInfor = $this->_common_infor;
        if (empty($params['artist']))
            $params['artist'] = $commonInfor;
        return array(
            "title" => $params['title'],
            "mediaDir" => $mediaDir,
            "media_name" => $mediaNewName,
            "bitrate" => $bitrate,
            "atid"  => $params['atid'],
            "cutoff" => $params['cutoff'],
            "artist" => $params['artist'],
            "album" => $commonInfor,
            "genre" => $commonInfor,
            "comment" => $commonInfor,
            "composer" => $commonInfor,
            "encoder" => $commonInfor

        );
    }

    ##########################  Upload video ##################################
    
    public function pushVideoUpload($params) {
        if ($this->_rabbitClient->isConnected()) {
            $result = $this->_rabbitClient->sendMessage($this->_upload_queue_name, $params);
        }        
    }
    
}

