<?php

namespace DjCms\Library\ArticleDetail;

class ZippyShare extends MusicHosting
{

    public function getDirectUri()
    {
        $urlInfo = parse_url($this->link);
        $arrPath = explode('/', $urlInfo['path']);
        $mediaId = $arrPath[2];
        return $this->baseUrl . "/zippyshare/" . $urlInfo['host'] . "/" . $mediaId . ".mp3";
    }
}