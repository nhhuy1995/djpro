<?php
namespace DjClient\Library\ArticleDetail;

class TuneScoop extends MusicHosting
{

    public function getDirectUri()
    {
        $data = file_get_contents($this->link);
        preg_match('/tss=\"([^"]+)\"/', $data, $match);
        return $match[1];
    }
}