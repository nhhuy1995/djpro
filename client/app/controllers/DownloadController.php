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
        $id = $this->request->get('id');
        $quality = $this->request->get('quality');
        $o = Media::findById($id);
        if ($o->type == 'video') {
            $youtubeDownloader = new YoutubeDownloader();
            $linkUrl = $youtubeDownloader->getLinkDownload($o->mediaurl, 'best');
            if ($linkUrl && strlen($linkUrl)) {
                header('Location: ' . $linkUrl);die;
            }
        }
        if($quality == '320k') $file = $o->media_link_320k;
        else if($quality == '128k') $file =  $o->media_link_128k;
        else if($quality == '64k') $file = $o->media_link_64k;
        else $file = $o->direct_media_url;
//        else $file = getcwd() . "/" . $o->direct_media_url;
        $exten = strtolower(end(explode(".", $file)));
        $filename = $o->namenonutf;
        $this->response->setFileToSend($file);
        $this->response->send();
    }

}

