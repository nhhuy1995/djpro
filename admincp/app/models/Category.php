<?php
namespace DjCms\Models;

use DjCms\Library\Makelink;
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

    public static function getLinkCategory($type, $name, $id)
    {
        if ($type == 'album' || $type == 'playlist' || $type == 'topic') $link = DOMAIN . Makelink::link_view_category_playlist($name, $id);
        else if ($type == 'artist') $link = DOMAIN . Makelink::link_view_category_artist($name, $id);
        else if ($type == 'video') $link = DOMAIN . Makelink::link_view_category_video($name, $id);
        else if ($type == 'audio') $link = DOMAIN . Makelink::link_view_category_music($name, $id);
        else $link = DOMAIN . Makelink::link_view_category_news($name, $id);
        return $link;
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
//        $type['rankingvideo'] = "Bảnh xếp hạng Video";
//        $type['rankingmusic'] = "Bảnh xếp hạng Music";
//        $type['rankingalbum'] = "Bảnh xếp hạng Album";
        if ($bykey != null) return $type[$bykey];
        else return $type;
    }

    public static function reMoveCateIDInTopic($listid, $catid)
    {

        $listTopic = Album::findAndReturnArray(array(
            'fields' => array('_id', 'name', 'category'),
            'condition' => array('_id' => array('$in' => $listid)),
        ));
        foreach ($listTopic as $item) {
            $id = $item['_id'];
            $listCate = array_values(array_diff($item['category'], array($catid)));
            Album::updateDocument(
                array('_id' => $id),
                array('$set' => array("category" => $listCate))
            );
        }
    }

    public static function recursive_to_html($cond, $nameinput, $checkedvalue = array())
    {

        $list = Category::find(array(
            'conditions' => $cond,
            "sort" => array("sort" => 1)
        ));
        $htmlx = "<ul class=\"p-l-20\">";
        foreach ($list as $item) {
            $cl = "";
            if (!empty($checkedvalue) && isset($checkedvalue)) {
                if (in_array($item->_id, $checkedvalue)) $cl = "checked";
            } else {
                if ($item->_id == '1451019676') $cl = "checked"; // set active defaut category id = 1451019676 for artist;
            }

            $htmlx .= '<li class="p-5 ' . $item->type . '">
            <label class="checkbox checkbox-inline m-r-20">
            <input value="' . $item->_id . '"data-type="' . $item->type . '" type="checkbox" ' . $cl . ' name="' . $nameinput . '" />
            <i class="input-helper"></i> ' . $item->name . '</label>';
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