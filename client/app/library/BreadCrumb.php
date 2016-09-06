<?php
namespace DjClient\Library;

class BreadCrumb
{
    protected $items;

    public function __construct()
    {
        $this->items = array();
    }

    public function addItem($item, $catType)
    {
        if (!empty($item)) array_push($this->items, $item);
        $this->prependMainCategory($catType);
    }

    public function addListItems($items, $catType)
    {
        $this->items = array_merge((array)$this->items, $items);
        $this->prependMainCategory($catType);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function prependMainCategory($catType)
    {
        $data = array(
            'audio' => array(
                "name" => "Bài hát",
                "link" => "/bai-hat.html"
            ),
            'news' => array(
                "name" => "Tin tức",
                "link" => "/tin-tuc.html"
            ),
            'images' => array(
                "name" => "Ảnh",
                "link" => "/anh.html"
            ),
            'video' => array(
                "name" => "Video",
                "link" => "/video.html"
            ),
            'artist' => array(
                "name" => "Nghệ sỹ",
                "link" => "/nghe-sy.html"
            ),
            'ranking' => array(
                "name" => "Bảng xếp hạng",
                "link" => "/bxh.html"
            ),
            'top100' => array(
                "name" => "TOP 100",
                "link" => "/top100.html"
            ),
            'topdecu' => array(
                "name" => "TOP đề cử",
                "link" => "/bai-hat-de-cu.html"
            ),
            'album' => array(
                "name" => "Album",
                "link" => "/album.html"
            ),
            'playlist' => array(
                "name" => "Playlist",
                "link" => "/playlist.html"
            ),
            'topic' => array(
                "name" => "Chủ đề",
                "link" => "/chu-de.html"
            ),
        );
        if ($data[$catType]) array_unshift($this->items, $data[$catType]);
    }
}