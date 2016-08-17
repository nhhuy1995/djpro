<?php
namespace DjClient\Library\ArticleDetail;
abstract class MusicHosting
{
    protected $link;
    protected $baseUrl;

    public function __construct($link, $baseUrl)
    {
        $this->link = $link;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Return Direct url to media
     * @return mixed
     */
    abstract public function getDirectUri();
}