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
        if ($catType == "audio") {
            array_unshift($this->items, array(
                "name" => "Bài hát",
                "link" => "/bai-hat.html"
            ));
        }
        if ($catType == "video") {
            array_unshift($this->items, array(
                "name" => "Video",
                "link" => "/video.html"
            ));
        }
        if ($catType == "artist") {
            array_unshift($this->items, array(
                "name" => "Nghệ sỹ",
                "link" => "/nghe-sy.html"
            ));
        }
    }
}