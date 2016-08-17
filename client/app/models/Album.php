<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Album
 * @package DjCms\Models
 * @author hungln
 * @description Album Collection in Db
 */
class Album extends BaseCollection
{
    public function getSource()
    {
        return "album";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    /*
     * @param: $type string
     * @param: $limit int
     * @param: $sort -> if == 1 is sort by datacreate , if == 2 is sort by view
     */
    public static function ListAlbumByMultiConditions($type, $limit, $sort, $listid = null)
    {
        if ($sort == 1) $sort = array('datecreate' => -1);
        else if ($sort == 2) $sort = array('view' => -1);
        else if ($sort == null) $sort = array();
        if ($listid == null) $cond = array('type' => $type, 'status' => static::$STATUS_ON);
        else $cond = array('_id' => array('$in' => $listid), 'status' => static::$STATUS_ON);
        $listalbum = Album::findAndReturnArray(array(
            'condition' => $cond,
            'sort' => $sort,
            'limit' => $limit,
        ));
        foreach ($listalbum as $key => $value) {
            $artistid = $value['artist'];
            $listalbum[$key]['link'] = Makelink::link_view_article_playlist_music($value['name'], $value['_id']);
            $listalbum[$key]['usercreate'] = Users::getUserInfo($value['usercreate']);
            $listalbum[$key]['priavatar'] = Helper::checkAvatar($value['usercreate'], $value['priavatar']);
            if (isset($artistid) || !empty($artistid)) $listalbum[$key]['listartist'] = Helper::resortarray(Artist::getArtistByID($artistid),$artistid,'_id');
            unset($artistid);
        }
        return $listalbum;
    }

    public static function getListAlbumByCategory($catid, $limit, $sort)
    {
        if ($sort == 1) $sort = array('datecreate' => -1);
        else if ($sort == 2) $sort = array('view' => -1);
        else if ($sort == 3) $sort = array('sort' => 1);
        $listalbum = Album::findAndReturnArray(array(
            'condition' => array('category' => $catid, 'status' => static::$STATUS_ON),
            'sort' => $sort,
            'limit' => $limit,
        ));
        foreach ($listalbum as $key => $value) {
            $artistid = $value['artist'];
            $listalbum[$key]['link'] = Makelink::link_view_article_playlist_music($value['name'], $value['_id']);
            $listalbum[$key]['usercreate'] = Users::getUserInfo($value['usercreate']);
            $listalbum[$key]['priavatar'] = Helper::checkAvatar($value['usercreate'], $value['priavatar']);
            if (isset($artistid)) $listmusic[$key]['listartist'] = Helper::resortarray(Artist::getArtistByID($artistid),$artistid,'_id');
            unset($artistid);
        }
        return $listalbum;
    }

    public static function getListAlbum_BySearch($keyword, $type, $limit)
    {
        $data = Album::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$keyword"), 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Helper::resortarray(Artist::getArtistByID($artistid),$artistid,'_id');
        }
        return $data;
    }
    public static function getListAlbum_ByTagID($tagid, $type, $limit)
    {
        $data = Album::findAndReturnArray(array(
            'condition' => array('tags' => $tagid, 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $item['priavatar'] = Helper::checkAvatar($item['usercreate'],$item['priavatar']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Helper::resortarray(Artist::getArtistByID($artistid),$artistid,'_id');
        }
        return $data;
    }
    public static function countAlbum_BySearch($keyword, $type)
    {
        return count(Album::findAndReturnArray(array('condition' => array('$text' => array('$search' => "$keyword"), 'type' => $type, 'status' => static::$STATUS_ON))));
    }
}