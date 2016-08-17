<?php
namespace DjClient\Controller;


use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Media;
use DjClient\Models\Users;

class ArtistController extends ControllerBase
{

    public function indexAction()
    {
        $limit = 8;
        $listcategory = Category::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_ARTIST, 'status' => static::$STATUS_ON),
            'sort' => array('sort' => 1),
        ));
        foreach ($listcategory as &$item) {
            $catid = $item['_id'];
            $item['link'] = Makelink::link_view_category_artist($item['name'], $item['_id']);
            $listArtist = Artist::findAndReturnArray(array(
                'fields' => array('_id', 'priavatar', 'username', 'link'),
                'condition' => array('category' => $catid,'status' => static::$STATUS_ON), 'limit' => $limit, 'sort' => array('datecreate' => -1)
            ));
            if ($listArtist) {
                foreach ($listArtist as $key => $itemchild) {
                    if (empty($itemchild['priavatar']) || !isset($itemchild['priavatar'])) $listArtist[$key]['priavatar'] = Helper::getAvatarDefault();
                    $listArtist[$key]['link'] = Makelink::link_view_artist($itemchild['username'], $itemchild['_id']);
                }
                $item['listartist'] = $listArtist;
            }
            unset($catid);
        }
        $this->view->setVars(array(
            'listcategory' => $listcategory,
            'title' => 'Nghệ sỹ',
        ));
    }

    public function categoryAction()
    {
        $catid = $this->dispatcher->getParam('catId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $o = Category::findById($catid);
        $o->link = Makelink::link_view_category_artist($o->name, $o->getId());
        $listArtist = Artist::findAndReturnArray(array(
            'condition' => array('category' => $catid,'status' => static::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $count = Artist::findAndReturnArray(array('condition' => array('category' => $catid,'status' => static::$STATUS_ON),));
        $this->view->setVars(array(
            'listartist' => $listArtist,
            'title' => $o->name,
            'category' => $o,
            'painginfo' => Helper::paginginfo(count($count), $limit, $p),
        ));
    }

    public function viewAction()
    {
        $type = $this->request->get('t');
        $id = $this->dispatcher->getParam('atId');
        if(isset($type)){
            if($type == static::$TYPE_MUSIC) $action = 'audio';
            if($type == static::$TYPE_ALBUM) $action = 'album';
            if($type == static::$TYPE_VIDEO) $action = 'video';
            if($type == 'info') $action = 'story';
            $this->dispatcher->forward(
                array('controller' => 'artist',
                    'action' => $action,
                ));
        }
        $object = Artist::findById($id);
        if (empty($object->banner) || !isset($object->banner)) $object->banner = Helper::getBannerDefault();
        if (empty($object->priavatar) || !isset($object->priavatar)) $object->priavatar = Helper::getAvatarDefault();
        $object->link = Makelink::link_view_artist($object->username, $object->getId());
        $listcatid = $object->category;
        if (!empty($listcatid) && isset($listcatid)) $listcat = Category::getCategoryByID(self::$TYPE_ARTIST, $listcatid);
        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON),
            'limit' => 10,
            'sort' => array('datecreate' => -1),
        ));
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_ALBUM, 'status' => self::$STATUS_ON),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listMedia as &$item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
        }
        //list video
        foreach ($listVideo as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        //list album
        foreach ($listAlbum as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        //list artist other
        $listArtist = Artist::findAndReturnArray(array('sort' => array('datecreate' => -1),'limit' => 10,));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $countaudio = count(Media::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON))));
        $countvideo = count(Media::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON))));
        $countalbum = count(Album::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_ALBUM, 'status' => self::$STATUS_ON))));
        $this->view->setVars(array(
            'listmedia' => $listMedia,
            'listvideo' => $listVideo,
            'listalbum' => $listAlbum,
            'listartist' => $listArtist,
            'listcategory' => $listcat,
            'countaudio' => $countaudio,
            'countvideo' => $countvideo,
            'countalbum' => $countalbum,
            'object' => $object,
            'title' => $object->username,
        ));
    }
    public function storyAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $object = Artist::findById($id);
        if (empty($object->banner) || !isset($object->banner)) $object->banner = Helper::getBannerDefault();
        if (empty($object->priavatar) || !isset($object->priavatar)) $object->priavatar = Helper::getAvatarDefault();
        $object->link = Makelink::link_view_artist($object->username, $object->getId());
        $listcatid = $object->category;
        if (!empty($listcatid) && isset($listcatid)) $listcat = Category::getCategoryByID(self::$TYPE_ARTIST, $listcatid);

        //list artist other
        $listArtist = Artist::findAndReturnArray(array('sort' => array('datecreate' => -1),'limit' => 10,));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $catid = $object->category;
        $listCate = array();
        if(isset($catid) && !empty($catid)){
            $listCate = Category::findAndReturnArray(array(
                'fields' => array('_id','name','type'),
                'condition' => array('_id' => array('$in' => $catid))
            ));
        }
        if(!isset($object->username) || empty($object->username)) $object->username = 'Đang cập nhật';
        if(!isset($object->realname) || empty($object->realname)) $object->realname = 'Đang cập nhật';
        if(!isset($object->from) || empty($object->from)) $object->from = 'Đang cập nhật';
        if(!isset($object->job) || empty($object->job)) $object->job = 'Đang cập nhật';
        if(!isset($object->playmusic) || empty($object->playmusic)) $object->playmusic = 'Đang cập nhật';
        if(!isset($object->yearjob) || empty($object->yearjob)) $object->yearjob = 'Đang cập nhật';
        if(!isset($object->clubdid) || empty($object->clubdid)) $object->clubdid = 'Đang cập nhật';
        if(!isset($object->birthday) || empty($object->birthday)) $object->birthday = 'Đang cập nhật';
        if(!isset($object->workingat) || empty($object->workingat)) $object->workingat = 'Đang cập nhật';
        if(!isset($object->hobby) || empty($object->hobby)) $object->hobby = 'Đang cập nhật';

        if($object->sex == 'na') $object->sex = 'N/A';
        else if ($object->sex == 'male') $object->sex = 'Nam';
        else if($object->sex == 'female') $object->sex = 'Nữ';
        else $object->sex = 'Đang cập nhật';

        if(isset($object->facebook) && !empty($object->facebook)) $object->facebook = "<a href=\"{$object->facebook}\" target=\"_blank\">{$object->facebook}</a>";
        else $object->facebook = 'Đang cập nhật';

        $this->view->setVars(array(
            'artisttype' => Helper::getAllArtistTypes(),
            'listartist' => $listArtist,
            'listcategory' => $listcat,
            'listCate' => $listCate,
            'object' => $object,
            'title' => $object->username,
        ));
    }
    public function audioAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $object = Artist::findById($id);
        if (empty($object->banner) || !isset($object->banner)) $object->banner = Helper::getBannerDefault();
        if (empty($object->priavatar) || !isset($object->priavatar)) $object->priavatar = Helper::getAvatarDefault();
        $object->link = Makelink::link_view_artist($object->username, $object->getId());
        $listcatid = $object->category;
        if (!empty($listcatid) && isset($listcatid)) $listcat = Category::getCategoryByID(self::$TYPE_ARTIST, $listcatid);
        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON),
            'limit' => 10,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));

        foreach ($listMedia as &$item)  $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
        //list artist other
        $listArtist = Artist::findAndReturnArray(array('sort' => array('datecreate' => -1),'limit' => 10,));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $count = count(Media::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON))));
        $this->view->setVars(array(
            'listmedia' => $listMedia,
            'listartist' => $listArtist,
            'listcategory' => $listcat,
            'painginfo' =>Helper::paginginfo($count, $limit, $p),
            'object' => $object,
            'title' => $object->username,
        ));
    }
    public function albumAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $object = Artist::findById($id);
        if (empty($object->banner) || !isset($object->banner)) $object->banner = Helper::getBannerDefault();
        if (empty($object->priavatar) || !isset($object->priavatar)) $object->priavatar = Helper::getAvatarDefault();
        $object->link = Makelink::link_view_artist($object->username, $object->getId());
        $listcatid = $object->category;
        if (!empty($listcatid) && isset($listcatid)) $listcat = Category::getCategoryByID(self::$TYPE_ARTIST, $listcatid);

        $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_ALBUM, 'status' => self::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));

        //list album
        foreach ($listAlbum as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        //list artist other
        $listArtist = Artist::findAndReturnArray(array('sort' => array('datecreate' => -1),'limit' => 10,));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $count = count(Album::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_ALBUM, 'status' => self::$STATUS_ON))));
        $this->view->setVars(array(
            'listalbum' => $listAlbum,
            'listartist' => $listArtist,
            'listcategory' => $listcat,
            'painginfo' =>Helper::paginginfo($count, $limit, $p),
            'object' => $object,
            'title' => $object->username,
        ));
    }
    public function videoAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $object = Artist::findById($id);
        if (empty($object->banner) || !isset($object->banner)) $object->banner = Helper::getBannerDefault();
        if (empty($object->priavatar) || !isset($object->priavatar)) $object->priavatar = Helper::getAvatarDefault();
        $object->link = Makelink::link_view_artist($object->username, $object->getId());
        $listcatid = $object->category;
        if (!empty($listcatid) && isset($listcatid)) $listcat = Category::getCategoryByID(self::$TYPE_ARTIST, $listcatid);
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        //list video
        foreach ($listVideo as &$item) {
            $artistid = $item['artist'];
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        //list artist other
        $listArtist = Artist::findAndReturnArray(array('sort' => array('datecreate' => -1),'limit' => 10,));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $count = count(Media::findAndReturnArray(array('condition' => array('artist' => $object->getId(), 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON))));
        $this->view->setVars(array(
            'listvideo' => $listVideo,
            'listartist' => $listArtist,
            'listcategory' => $listcat,
            'painginfo' =>Helper::paginginfo($count, $limit, $p),
            'object' => $object,
            'title' => $object->username,
        ));
    }
}

