<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Media;
use DjClient\Models\Tags;

class TagsController extends ControllerBase
{
    public function indexAction()
    {
        $type = $this->request->get('t');
        $tID = $this->dispatcher->getParam('tId');
        if (isset($type)) { // if exist type then redirect page
            $articleType = array(static::$TYPE_MUSIC, static::$TYPE_VIDEO, static::$TYPE_NEWS, static::$TYPE_IMAGES);
            $collectionType = array(static::$TYPE_ALBUM, static::$TYPE_PLAYLIST, static::$TYPE_TOPIC);
            // if type exist in array type then redirect
            if (in_array($type, $articleType)) $action = 'media';
            if (in_array($type, $collectionType)) $action = 'playlist';
            $this->dispatcher->forward(
                array('controller' => 'tags',
                    'action' => $action,
                ));
        }

        $o = Tags::findById($tID);
        $o->link = Makelink::link_view_tags_index($o->name, $o->getId());
        ##list media
        $listVideo = Media::getListMedia_ByTagsID($tID, static::$TYPE_VIDEO, 4);//list video
        $listNews = Media::getListMedia_ByTagsID($tID, static::$TYPE_NEWS, 4);//list news
        $listImages = Media::getListMedia_ByTagsID($tID, static::$TYPE_IMAGES, 4);//list images
        $listAudio = Media::getListMedia_ByTagsID($tID, static::$TYPE_MUSIC, 10);//list audio
        $listAlbum = Album::getListAlbum_ByTagID($tID, static::$TYPE_ALBUM, 4); //list album
        $listPlaylist = Album::getListAlbum_ByTagID($tID, static::$TYPE_PLAYLIST, 4); //list playlist
        $listTopic = Album::getListAlbum_ByTagID($tID, static::$TYPE_TOPIC, 4); //list topic
        ##count
        $countVideo = Media::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_ON)));
        $countAudio = Media::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_ON)));
        $countNews = Media::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_NEWS, 'status' => static::$STATUS_ON)));
        $countImages = Media::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_IMAGES, 'status' => static::$STATUS_ON)));
        $countAlbum = Album::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_ALBUM, 'status' => static::$STATUS_ON)));
        $countPlaylist = Album::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_PLAYLIST, 'status' => static::$STATUS_ON)));
        $countTopic = Album::count(array('conditions' => array('tags' => $tID, 'type' => static::$TYPE_TOPIC, 'status' => static::$STATUS_ON)));

        $this->view->setVars(array(
            'listaudio' => $listAudio,
            'listnews' => $listNews,
            'listimages' => $listImages,
            'listvideo' => $listVideo,
            'listalbum' => $listAlbum,
            'listplaylist' => $listPlaylist,
            'listtopic' => $listTopic,
            'countaudio' => $countAudio,
            'countvideo' => $countVideo,
            'countnews' => $countNews,
            'countimages' => $countImages,
            'countalbum' => $countAlbum,
            'countplaylist' => $countPlaylist,
            'counttopic' => $countTopic,
            'object' => $o,
            'link_view_tags_audio' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=audio',
            'link_view_tags_video' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=video',
            'link_view_tags_news' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=news',
            'link_view_tags_images' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=images',
            'link_view_tags_topic' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=topic',
            'link_view_tags_album' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=album',
            'link_view_tags_playlist' => Makelink::link_view_tags_index($o->name, $o->getId()) . '?t=playlist',
        ));
        $this->view->header = Helper::setHeader('Danh sách media theo tag ' . $o->name,$o->description, $o->priavatar);
    }

    /*public function musicAction()
    {
        $tagid = $this->dispatcher->getParam('tId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $this->mediaAction($tagid, static::$TYPE_MUSIC, $skip, $limit, $p);
    }

    public function newsAction()
    {
        $p = $_GET['p'];
        $tagid = $this->dispatcher->getParam('tId');
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $this->mediaAction($tagid, static::$TYPE_NEWS, $skip, $limit, $p);
    }

    public function imagesAction()
    {
        $p = $_GET['p'];
        $tagid = $this->dispatcher->getParam('tId');
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $this->mediaAction($tagid, static::$TYPE_IMAGES, $skip, $limit, $p);
    }

    public function videoAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 15;
        $skip = ($p - 1) * $limit;
        $tagid = $this->dispatcher->getParam('tId');
        $this->mediaAction($tagid, static::$TYPE_VIDEO, $skip, $limit, $p);
    }*/

    /*public function topicAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $tagid = $this->dispatcher->getParam('tId');
        $this->teamplateplaylistAction($tagid, static::$TYPE_TOPIC, $skip, $limit, $p);
    }*/

    /*public function albumAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $tagid = $this->dispatcher->getParam('tId');
        $this->teamplateplaylistAction($tagid, static::$TYPE_ALBUM, $skip, $limit, $p);
    }*/

    /* public function playlistAction()
     {
         $p = $_GET['p'];
         if ($p <= 1) $p = 1;
         $limit = 12;
         $skip = ($p - 1) * $limit;
         $tagid = $this->dispatcher->getParam('tId');
         $this->teamplateplaylistAction($tagid, static::$TYPE_PLAYLIST, $skip, $limit, $p);
     }*/

    public function playlistAction()
    {
        $p = $this->request->get('p');
        $type = $this->request->get('t');
        $tagid = $this->dispatcher->getParam('tId');
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $o = Tags::findById($tagid);
        $o->link = Makelink::link_view_tags_index($o->name, $o->getId());
        $listdata = Album::findAndReturnArray(array(
            'condition' => array('tags' => $tagid, 'type' => $type, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listdata as &$item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $item['priavatar'] = Helper::checkAvatar($item['usercreate'], $item['priavatar']);
            $data[] = $item;
        }
        $count = Album::count(array('conditions' => array('tags' => $tagid, 'type' => $type, 'status' => static::$STATUS_ON)));
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->listdata = $data;
        $this->view->object = $o;
        $this->view->header = Helper::setHeader($o->name,$o->description, $o->priavatar);
        if ($type == static::$TYPE_PLAYLIST) $view = 'tags/playlist';
        if ($type == static::$TYPE_TOPIC) $view = 'tags/topic';
        if ($type == static::$TYPE_ALBUM) $view = 'tags/album';
        $this->view->pick($view);
    }


    public function mediaAction()
    {
        $p = $this->request->get('p');
        $tagid = $this->dispatcher->getParam('tId');
        $type = $this->request->get('t');
        if ($p <= 1) $p = 1;
        if ($type == static::$TYPE_MUSIC) {
            $view = 'tags/music';
            $limit = 10;
        }
        if ($type == static::$TYPE_NEWS) {
            $view = 'tags/news';
            $limit = 6;
        }
        if ($type == static::$TYPE_IMAGES) {
            $view = 'tags/images';
            $limit = 6;
        }
        if ($type == static::$TYPE_VIDEO) {
            $view = 'tags/video';
            $limit = 15;
        }
        $skip = ($p - 1) * $limit;
        $o = Tags::findById($tagid);
        $o->link = Makelink::link_view_tags_index($o->name, $o->getId());
        $listdata = Media::findAndReturnArray(array(
            'condition' => array('type' => $type, 'tags' => $tagid, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listdata as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            if ($item['type'] == static::$TYPE_MUSIC) $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            else if ($item['type'] == static::$TYPE_VIDEO) $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            else $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            $item['priavatar'] = Helper::checkAvatar($item['usercreate'], $item['priavatar']);
            $data[] = $item;
        }
        $count = Media::count(array('conditions' => array('type' => $type, 'tags' => $tagid, 'status' => static::$STATUS_ON)));

        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->listdata = $data;
        $this->view->object = $o;
        $this->view->header = Helper::setHeader($o->name,$o->description, $o->priavatar);
        $this->view->pick($view);
    }


}

