<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Media
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Media extends BaseCollection
{

    public function getSource()
    {
        return "media";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    /*
     * @param: $type string
     * @param: $limit int
     * @param: $sort -> if == 1 is sort by datacreate , if == 2 is sort by view
     * @param: $listid array
     */
    public static function ListMusicByMultiConditions($type, $limit, $sort, $listid = null)
    {
        if ($sort == 1) $sort = array('datecreate' => -1);
        else if ($sort == 2) $sort = array('view' => -1);
        if ($listid == null) $cond = array('type' => $type, 'status' => static::$STATUS_ON);
        else $cond = array('_id' => array('$in' => $listid), 'status' => static::$STATUS_ON);
        $listmusic = Media::findAndReturnArray(array(
            'condition' => $cond,
            'sort' => $sort,
            'limit' => $limit,
        ));
        foreach ($listmusic as $key => $value) {
            $usercreate_id = $value['usercreate'];
            $artistid = $value['artist'];
            if ($value['type'] == self::$TYPE_VIDEO) $makelink = Makelink::link_view_article_video($value['name'], $value['_id']);
            if ($value['type'] == self::$TYPE_MUSIC) $makelink = Makelink::link_view_article_music($value['name'], $value['_id']);
            $listmusic[$key]['link'] = $makelink;
            if (!empty($artistid)) $listmusic[$key]['listartist'] = Artist::getArtistByID($artistid);
//            $listmusic[$key]['usercreate'] = Users::getUserInfo($usercreate_id);
            unset($artistid);
        }
        return $listmusic;
    }

    public static function getListMedia_BySearch($keyword, $type, $limit)
    {
        $data = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$keyword"), 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate', -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            if ($item['type'] == 'audio') $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            else $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        return $data;
    }
    public static function getListMedia_ByTagsID($tagid,$type,$limit){
        $data = Media::findAndReturnArray(array(
            'condition' => array('tags' => $tagid, 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate', -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            if ($item['type'] == 'audio') $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            else if ($item['type'] == 'news') $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            else $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            $item['priavatar'] = Helper::checkAvatar($item['usercreate'],$item['priavatar']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        return $data;
    }
}