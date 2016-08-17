<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Media;
use DjClient\Models\Users;

class SearchController extends ControllerBase
{

    public function indexAction()
    {
        $q = Helper::convertToUtf8($_GET['q']);
        ##list
        $listVideo = Media::getListMedia_BySearch($q, static::$TYPE_VIDEO, 4);//list video
        $listAudio = Media::getListMedia_BySearch($q, static::$TYPE_MUSIC, 10);//list audio
        $listAlbum = Album::getListAlbum_BySearch($q, static::$TYPE_ALBUM, 4); //list album
        $listPlaylist = Album::getListAlbum_BySearch($q, static::$TYPE_PLAYLIST, 4); //list playlist
        $listTopic = Album::getListAlbum_BySearch($q, static::$TYPE_TOPIC, 4); //list topic
        ##count
        $countVideo = count(Media::findAndReturnArray(array('condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_ON))));
        $countAudio = count(Media::findAndReturnArray(array('condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_ON))));
        $countAlbum = Album::countAlbum_BySearch($q, static::$TYPE_ALBUM);
        $countPlaylist = Album::countAlbum_BySearch($q, static::$TYPE_PLAYLIST);
        $countTopic = Album::countAlbum_BySearch($q, static::$TYPE_TOPIC);
        $countArtist = count($listArtist = Artist::findAndReturnArray(array(
            'fields' => array('_id', 'username', 'priavatar', 'link'),
            'condition' => array('$text' => array('$search' => "$q")),
        )));
        $countTotal = ($countAudio + $countVideo + $countAlbum + $countPlaylist + $countTopic + $countArtist);
        //List artist
        $listArtist = Artist::findAndReturnArray(array(
            'fields' => array('_id', 'username', 'priavatar', 'link'),
            'condition' => array('$text' => array('$search' => "$q")),
            'sort' => array('datecreate', -1),
            'limit' => 4,
        ));
        foreach ($listArtist as &$item) {
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
        }
        ##convert keyword
        $keyword = str_replace(' ', '+', $q);
        $this->view->setVars(array(
            'keyword' => $keyword,
            'listaudio' => $listAudio,
            'listvideo' => $listVideo,
            'listalbum' => $listAlbum,
            'listplaylist' => $listPlaylist,
            'listtopic' => $listTopic,
            'listartist' => $listArtist,
            'countaudio' => $countAudio,
            'countvideo' => $countVideo,
            'countalbum' => $countAlbum,
            'countplaylist' => $countPlaylist,
            'counttopic' => $countTopic,
            'countartist' => $countArtist,
            'countTotal' => $countTotal,
        ));
        $this->view->header = Helper::setHeader('Tìm kiếm','', '');
    }

    public function audioAction()
    {
        $q = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $listAudio = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate',-1),
            'limit' => $limit,
            'skip' => $skip,
        ));
        $countAudio = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
        ));
        foreach ($listAudio as &$item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
        }
        ##convert keyword
        $keyword = str_replace(' ', '+', $q);
        $this->view->setVars(array(
            'keyword' => $keyword,
            'listaudio' => $listAudio,
            'painginfo' => Helper::paginginfo(count($countAudio), $limit, $p),
            'countaudio' => count($countAudio),
        ));
        $this->view->header = Helper::setHeader('Tìm kiếm theo nhạc','', '');
    }

    public function videoAction()
    {
        $q = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate',-1),
            'limit' => $limit,
            'skip' => $skip,
        ));
        $countVideo = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q"), 'type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_ON),
        ));
        foreach ($listVideo as &$item) {
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
        }
        ##convert keyword
        $keyword = str_replace(' ', '+', $q);
        $this->view->setVars(array(
            'keyword' => $keyword,
            'listvideo' => $listVideo,
            'painginfo' => Helper::paginginfo(count($countVideo), $limit, $p),
            'countvideo' => count($countVideo),
        ));
        $this->view->header = Helper::setHeader('Tìm kiếm theo Video','', '');
    }

    public function artistAction()
    {
        $q = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listArtist = Artist::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q")),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $count = Artist::findAndReturnArray(array('condition' => array('$text' => array('$search' => "$q"))));
        ##convert keyword
        $keyword = str_replace(' ', '+', $q);
        $this->view->setVars(array(
            'keyword' => $keyword,
            'listartist' => $listArtist,
            'countartist' => count($count),
            'painginfo' => Helper::paginginfo(count($count), $limit, $p),
        ));
        $this->view->header = Helper::setHeader('Tìm kiếm theo nghệ sỹ','', '');
    }

    public function albumAction()
    {
        $keyword = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        $this->getAlbumOrPlaylistOrTopic($keyword, self::$TYPE_ALBUM, $p, 12);
    }

    public function playlistAction()
    {
        $keyword = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        $this->getAlbumOrPlaylistOrTopic($keyword, self::$TYPE_PLAYLIST, $p, 12);
    }

    public function topicAction()
    {
        $keyword = Helper::convertToUtf8($_GET['q']);
        $p = $_GET['p'];
        $this->getAlbumOrPlaylistOrTopic($keyword, self::$TYPE_TOPIC, $p, 12);
    }

    function getAlbumOrPlaylistOrTopic($keyword, $type, $p, $limit)
    {
        $q = Helper::convertToUtf8($_GET['q']);
        if ($p <= 1) $p = 1;
        $skip = ($p - 1) * $limit;
        $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$q"), 'type' => $type, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listAlbum as &$item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
        }
        $count = Album::findAndReturnArray(array('condition' => array('$text' => array('$search' => "$q"), 'type' => $type, 'status' => static::$STATUS_ON)));
        if ($type == self::$TYPE_ALBUM) $title = "Tìm kiếm theo Album";
        else if ($type == self::$TYPE_TOPIC) $title = "Tìm kiếm theo Chủ đề";
        else if ($type == self::$TYPE_PLAYLIST) $title = "Tìm kiếm theo Playlist";
        ##convert keyword
        $keyword = str_replace(' ', '+', $q);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->count = count($count);
        $this->view->keyword = $keyword;
        $this->view->listdata = $listAlbum; 
        $this->view->header = Helper::setHeader($title,'', '');
    }
}

