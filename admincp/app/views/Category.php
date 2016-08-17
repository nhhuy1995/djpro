<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Category
 * @package DjCms\Models
 * @author huynh
 * @description Category Collection in Db
 */
class Category extends BaseCollection
{
//    protected static $_collect_instance;
    public function getSource()
    {
        return "category";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function list_type($bykey = null)
    {
        $type['news'] = "Tin tức";
        $type['video'] = "Video";
        $type['images'] = "Hình ảnh";
        $type['audio'] = "Audio";
        $type['album'] = "Album";
        $type['playlist'] = "Playlist";
        $type['topic'] = "Topic";
        $type['artist'] = "Nghệ sĩ";
        $type['rankingvideo'] = "Bảnh xếp hạng Video";
        $type['rankingmusic'] = "Bảnh xếp hạng Music";
        $type['rankingalbum'] = "Bảnh xếp hạng Album";
        if ($bykey != null) return $type[$bykey];
        else return $type;
    }

    public static function recursive_to_html($cond, $nameinput, $checkedvalue = array())
    {
        $list = Category::find(array(
            $cond,
            "sort" => array("sort" => 1)
        ));
        $htmlx = "<ul class=\"p-l-20\">";
        foreach ($list as $item) {
            $cl = "";
            if (in_array($item->_id, $checkedvalue)) $cl = "checked";
            $htmlx .= '<li class="p-5 '.$item->type.'"><label class="checkbox checkbox-inline m-r-20"><input value="' . $item->_id . '"data-type="'.$item->type.'" type="checkbox" ' . $cl . ' name="' . $nameinput . '" /> <i class="input-helper"></i> ' . $item->name . '</label>';
            if (Category::count(array("parentid" => $item->_id)) > 0) {
                $cond['parentid'] = $item->_id;
                $htmlx .= Category::recursive_to_html($cond, $nameinput, $checkedvalue);
            }
            $htmlx .= "</li>";
        }
        $htmlx .= "</ul>";
        return $htmlx;
    }
}