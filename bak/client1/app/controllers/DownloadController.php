<?php
namespace DjClient\Controller;

use DjClient\Models\Media;
use DjClient\Services\YoutubeDownloader;

class DownloadController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $sitename = $this->config->application->site;
        $id = $_GET['id'];
        $o = Media::findById($id);
        if ($o->type == 'video') {
            $youtubeDownloader = new YoutubeDownloader();
            $linkUrl = $youtubeDownloader->getLinkDownload($o->mediaurl, 'best');
            if ($linkUrl && strlen($linkUrl)) {
                header('Location: ' . $linkUrl);die;
            }
        }
//        $file = getcwd() . "/" . $o->mediaurl;
        $file = getcwd() . "/" . $o->direct_media_url;
        $exten = strtolower(end(explode(".", $file)));
        $filename = $o->namenonutf;
        $this->response->setFileToSend($file);
        $this->response->send();
    }
}

