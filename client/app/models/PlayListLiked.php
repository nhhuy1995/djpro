<?php
class PlayListLiked extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "playlistliked";
    }

    public $plid;
    public $userid;
    public $type;
}
?>