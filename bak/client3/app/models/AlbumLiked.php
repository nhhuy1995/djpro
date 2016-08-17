<?php
class AlbumLiked extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "albumliked";
    }

    public $alid;
    public $userid;
    public $type;
}
?>