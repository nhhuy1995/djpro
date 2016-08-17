<?php
namespace DjCms\Library\ArticleDetail;

class SoundCloud extends MusicHosting
{
    protected $clientID = "15d2ec16e436db90303c6438ead51450";
    private $id;

    public function getDirectUri()
    {
        $trackinforURL = "http://api.soundcloud.com/resolve.json?url={$this->link}&client_id={$this->clientID}";
        $content = file_get_contents($trackinforURL);
        $trackJS = json_decode($content);
        if ($trackJS) {
            $this->id = $trackJS->id;
            $streamURL = $this->baseUrl . "/soundcloud/{$trackJS->id}.mp3";
            return $streamURL;
        }
    }
}