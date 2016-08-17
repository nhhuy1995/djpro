<?php
namespace DjClient\Models;

use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Category
 * @package DjCms\Models
 * @author hungln
 * @description Category Collection in Db
 */
class Category extends BaseCollection
{
    public function getSource()
    {
        return "category";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getCategoryByID($type,$listid)
    {
        $listCategory = Category::findAndReturnArray(array(
            'fields' => array('_id', 'name', 'type'),
            'condition' => array('_id' => array('$in' => $listid)),
        ));
        foreach ($listCategory as &$item) {
            if ($type == self::$TYPE_MUSIC) $makelink = Makelink::link_view_category_music($item['name'], $item['_id']);
            else if ($type == self::$TYPE_VIDEO) $makelink = Makelink::link_view_category_video($item['name'], $item['_id']);
            else if ($type == self::$TYPE_ARTIST) $makelink = Makelink::link_view_category_artist($item['name'], $item['_id']);
            else if ($type == self::$TYPE_NEWS) $makelink = Makelink::link_view_category_news($item['name'], $item['_id']);
            else if ($type == self::$TYPE_IMAGES) $makelink = Makelink::link_view_category_images($item['name'], $item['_id']);
            else $makelink = Makelink::link_view_category_playlist($item['name'], $item['_id']);
            $item['link'] = $makelink;
        }
        return $listCategory;
    }

    public static function getAllCategory()
    {
        $listCategory = Category::findAndReturnArray();
        foreach ($listCategory as &$item) {
            if ($item['type'] == self::$TYPE_MUSIC) $makelink = Makelink::link_view_category_music($item['name'], $item['_id']);
            if ($item['type'] == self::$TYPE_VIDEO) $makelink = Makelink::link_view_category_video($item['name'], $item['_id']);
            $item['link'] = $makelink;

        }
        return $listCategory;
    }
}