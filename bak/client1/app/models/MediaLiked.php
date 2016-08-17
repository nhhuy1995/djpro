<?php
class MediaLiked extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "medialiked";
    }

    public $atid;
    public $userid;
    public $type;
}
?>