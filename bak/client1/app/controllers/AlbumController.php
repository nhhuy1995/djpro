<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Media;
use DjClient\Models\Settings;
use DjClient\Models\Users;

class AlbumController extends ControllerBase
{
    public static $TYPE_SELECTIVE_ALBUM = 'selective_album';

    public function indexAction()
    {

        $limit = 8;
        $listAlbum = Album::ListAlbumByMultiConditions(self::$TYPE_ALBUM, $limit, 1);
        //list album selective
        $listIdAlbum = Settings::getElementByKey(self::$TYPE_SELECTIVE_ALBUM);
        $listAlbumSelectvie = Helper::resortarray(Album::ListAlbumByMultiConditions(self::$TYPE_SELECTIVE_ALBUM, $limit, 1, $listIdAlbum), $listIdAlbum, "_id");
        $this->view->listalbum = $listAlbum;
        $this->view->listalbumselective = $listAlbumSelectvie;
        $this->view->title = 'Album';
    }

    public function newAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_ALBUM, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listAlbum as &$item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_ALBUM, 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listalbum = $data;
        $this->view->title = 'Album mới nhất';
    }

    public function selectiveAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listIdAlbum = Settings::getElementByKey(self::$TYPE_SELECTIVE_ALBUM);
        $list_SelectiveAlbum = Album::findAndReturnArray(array(
            'fields' => array('name', '_id', 'view', 'usercreate', 'priavatar', 'artist', 'listartist'),
            'condition' => array('_id' => array('$in' => $listIdAlbum), 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'skip' => $skip,
            'limit' => $limit,
        ));
        $list_SelectiveAlbum = Helper::resortarray($list_SelectiveAlbum, $listIdAlbum, "_id");
        foreach ($list_SelectiveAlbum as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdAlbum), 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listAlbum_selective = $data;
        $this->view->title = 'Album chọn lọc';
    }
}

