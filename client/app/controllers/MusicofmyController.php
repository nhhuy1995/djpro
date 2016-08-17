<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Token_key;
use DjClient\Models\Users;
use DjClient\Services\Email;

class MusicofmyController extends ControllerBase
{
    /*
     * @description: music of my status = 1
     *
     */
    public function indexonAction()
    {
        $uinfo = $this->session->get('uinfo');
        $type = $this->request->get('t');
        if(isset($type)){
            if($type == static::$TYPE_MUSIC) $action = 'audioon';
            if($type == static::$TYPE_PLAYLIST) $action = 'playliston';
            if($type == static::$TYPE_VIDEO) $action = 'videoon';
            $this->dispatcher->forward(
                array('controller' => 'musicofmy',
                    'action' => $action,
                ));
        }
        $uid = $uinfo['_id'];
        if (!isset($uid)) $this->response->redirect('/dang-nhap.html');
        $o = Users::getUserById($uid); // get namerole
        $uinfo['namerole'] = $o->namerole;
        $uinfo['is_role'] = $o->is_role;
        $uinfo['link'] = Makelink::link_view_member($uinfo['username'], $uinfo['_id']);
        $timeactivity = $o->timeactivity;
        if (isset($timeactivity)) $uinfo['timeactivity'] = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo['timeactivity'] = 'Chưa cập nhật!';
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo['totalmedia'] = count($total_media); // count media
        $uinfo['totalcomment'] = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo['totallikemedia'] = $totallikemedia;
        $uinfo['totaldislikemedia'] = $totaldislikemedia;

        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON),
            'limit' => 10,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMedia as $item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $this->view->listmedia = $data;
        unset($data);
        //list video
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listVideo as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarVideoDefault();
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        $this->view->listvideo = $data;
        unset($data);
        //list playlist
        $listPlaylist = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_ON),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listPlaylist as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        // validate user
        if ($uinfo['birthday'] == null || !isset($uinfo['birthday'])) $uinfo['birthday'] = "Chưa cập nhật!";
        else $uinfo['birthday'] = date('d/m/Y', $uinfo['birthday']);
        if ($uinfo['fullname'] == '') $uinfo['fullname'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == null) $uinfo['sex'] = "Chưa cập nhật!";
        if ($uinfo['facebook'] == '') $uinfo['facebook'] = "Chưa cập nhật!";
        if ($uinfo['yahoo'] == '') $uinfo['yahoo'] = "Chưa cập nhật!";
        if ($uinfo['skype'] == '') $uinfo['skype'] = "Chưa cập nhật!";
        if ($uinfo['phone'] == '') $uinfo['phone'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['hobby'] == '') $uinfo['hobby'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == 'male') $uinfo['sex'] = 'Nam';
        else if ($uinfo['sex'] == 'female') $uinfo['sex'] = 'Nữ';
        else if ($uinfo['sex'] == 'NA') $uinfo['sex'] = 'N/A';
        $this->view->countaudio = Media::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON)));
        $this->view->countvideo = Media::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON)));
        $this->view->countplaylist = Album::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_ON)));
        $this->view->listplaylist = $data;
        $this->view->uinfo = $uinfo;
        unset($data);
        $this->view->header = Helper::setHeader('Danh sách nhạc đã duyệt của tôi ','', '');
    }

    /*
     * @description: audio upload of my status = 1
     *
     */
    public function audioonAction()
    {
        $this->musicofmy(self::$TYPE_MUSIC,self::$STATUS_ON);
    }

    /*
     * @description: video upload of my status = 1
     *
     */
    public function videoonAction()
    {
        $this->musicofmy(self::$TYPE_VIDEO,self::$STATUS_ON);
    }

    /*
     * @description: playlist upload of my status = 1
     *
     */
    public function playlistonAction()
    {
        $this->musicofmy(self::$TYPE_PLAYLIST,self::$STATUS_ON);
    }

    /*
         * @description: music of my status = 3
         *
         */
    public function indexoffAction()
    {
        $type = $this->request->get('t');
        if(isset($type)){
            if($type == static::$TYPE_MUSIC) $action = 'audiooff';
            if($type == static::$TYPE_PLAYLIST) $action = 'playlistoff';
            if($type == static::$TYPE_VIDEO) $action = 'videooff';
            $this->dispatcher->forward(
                array('controller' => 'musicofmy',
                    'action' => $action,
                ));
        }
        $uinfo = $this->session->get('uinfo');
        $uid = $uinfo['_id'];
        if (!isset($uinfo)) $this->response->redirect('/dang-nhap.html');
        $o = Users::getUserById($uinfo['_id']); // get namerole
        $uinfo['namerole'] = $o->namerole;
        $uinfo['is_role'] = $o->is_role;
        $uinfo['link'] = Makelink::link_view_member($uinfo['username'], $uinfo['_id']);
        $timeactivity = $o->timeactivity;
        if (isset($timeactivity)) $uinfo['timeactivity'] = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo['timeactivity'] = 'Chưa cập nhật!';
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo['totalmedia'] = count($total_media); // count media
        $uinfo['totalcomment'] = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo['totallikemedia'] = $totallikemedia;
        $uinfo['totaldislikemedia'] = $totaldislikemedia;
        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_HIDDEN),
            'limit' => 10,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMedia as $item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $this->view->listmedia = $data;
        unset($data);
        //list video
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_HIDDEN),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listVideo as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarVideoDefault();
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        $this->view->listvideo = $data;
        unset($data);
        //list playlist
        $listPlaylist = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_HIDDEN),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listPlaylist as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        // validate user
        if ($uinfo['birthday'] == null || !isset($uinfo['birthday'])) $uinfo['birthday'] = "Chưa cập nhật!";
        else $uinfo['birthday'] = date('d/m/Y', $uinfo['birthday']);
        if ($uinfo['fullname'] == '') $uinfo['fullname'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == null) $uinfo['sex'] = "Chưa cập nhật!";
        if ($uinfo['facebook'] == '') $uinfo['facebook'] = "Chưa cập nhật!";
        if ($uinfo['yahoo'] == '') $uinfo['yahoo'] = "Chưa cập nhật!";
        if ($uinfo['skype'] == '') $uinfo['skype'] = "Chưa cập nhật!";
        if ($uinfo['phone'] == '') $uinfo['phone'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['hobby'] == '') $uinfo['hobby'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == 'male') $uinfo['sex'] = 'Nam';
        else if ($uinfo['sex'] == 'female') $uinfo['sex'] = 'Nữ';
        else if ($uinfo['sex'] == 'NA') $uinfo['sex'] = 'N/A';
        $this->view->countaudio = Media::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_HIDDEN)));
        $this->view->countvideo = Media::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_HIDDEN)));
        $this->view->countplaylist = Album::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_HIDDEN)));
        $this->view->listplaylist = $data;
        $this->view->uinfo = $uinfo;
        unset($data);
        $this->view->header = Helper::setHeader('Danh sách nhạc chờ duyệt của tôi ','', '');
    }

    /*
     * @description: audio upload of my status = 3
     *
     */
    public function audiooffAction()
    {
        $this->musicofmy(self::$TYPE_MUSIC,self::$STATUS_HIDDEN);
    }

    /*
     * @description: video upload of my status = 3
     *
     */
    public function videooffAction()
    {
        $this->musicofmy(self::$TYPE_VIDEO,self::$STATUS_HIDDEN);
    }

    /*
     * @description: playlist upload of my status = 3
     *
     */
    public function playlistoffAction()
    {
        $this->musicofmy(self::$TYPE_PLAYLIST,self::$STATUS_HIDDEN);
    }

    /*
         * @description: music of my status = 2
         *
         */
    public function indexdeleteAction()
    {
        $type = $this->request->get('t');
        if(isset($type)){
            if($type == static::$TYPE_MUSIC) $action = 'audiodelete';
            if($type == static::$TYPE_PLAYLIST) $action = 'playlistdelete';
            if($type == static::$TYPE_VIDEO) $action = 'videodelete';
            $this->dispatcher->forward(
                array('controller' => 'musicofmy',
                    'action' => $action,
                ));
        }
        $uinfo = $this->session->get('uinfo');
        $uid = $uinfo['_id'];
        if (!isset($uid)) $this->response->redirect('/dang-nhap.html');
        $o = Users::getUserById($uid); // get namerole
        $uinfo['namerole'] = $o->namerole;
        $uinfo['is_role'] = $o->is_role;
        $uinfo['link'] = Makelink::link_view_member($uinfo['username'], $uinfo['_id']);
        $timeactivity = $o->timeactivity;
        if (isset($timeactivity)) $uinfo['timeactivity'] = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo['timeactivity'] = 'Chưa cập nhật!';
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo['totalmedia'] = count($total_media); // count media
        $uinfo['totalcomment'] = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo['totallikemedia'] = $totallikemedia;
        $uinfo['totaldislikemedia'] = $totaldislikemedia;

        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_DELETE),
            'limit' => 10,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMedia as $item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $this->view->listmedia = $data;
        unset($data);
        //list video
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_DELETE),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listVideo as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarVideoDefault();
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        $this->view->listvideo = $data;
        unset($data);
        //list playlist
        $listPlaylist = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_DELETE),
            'limit' => 8,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listPlaylist as $item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }

        // validate user
        if ($uinfo['birthday'] == null || !isset($uinfo['birthday'])) $uinfo['birthday'] = "Chưa cập nhật!";
        else $uinfo['birthday'] = date('d/m/Y', $uinfo['birthday']);
        if ($uinfo['fullname'] == '') $uinfo['fullname'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == null) $uinfo['sex'] = "Chưa cập nhật!";
        if ($uinfo['facebook'] == '') $uinfo['facebook'] = "Chưa cập nhật!";
        if ($uinfo['yahoo'] == '') $uinfo['yahoo'] = "Chưa cập nhật!";
        if ($uinfo['skype'] == '') $uinfo['skype'] = "Chưa cập nhật!";
        if ($uinfo['phone'] == '') $uinfo['phone'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['hobby'] == '') $uinfo['hobby'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == 'male') $uinfo['sex'] = 'Nam';
        else if ($uinfo['sex'] == 'female') $uinfo['sex'] = 'Nữ';
        else if ($uinfo['sex'] == 'NA') $uinfo['sex'] = 'N/A';
        $this->view->countaudio = count(Media::findAndReturnArray(array('condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_DELETE))));
        $this->view->countvideo = count(Media::findAndReturnArray(array('condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_DELETE))));
        $this->view->countplaylist = count(Album::findAndReturnArray(array('condition' => array('usercreate' => $uinfo['_id'], 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_DELETE))));
        $this->view->listplaylist = $data;
        $this->view->uinfo = $uinfo;
        unset($data);
        $this->view->header = Helper::setHeader('Danh sách nhạc đã xóa của tôi ','', '');
    }

    /*
     * @description: audio upload of my status = 2
     *
     */
    public function audiodeleteAction()
    {
        $this->musicofmy(self::$TYPE_MUSIC,self::$STATUS_DELETE);
    }

    /*
     * @description: video upload of my status = 2
     *
     */
    public function videodeleteAction()
    {
        $this->musicofmy(self::$TYPE_VIDEO,self::$STATUS_DELETE);
    }

    /*
     * @description: playlist upload of my status = 2
     *
     */
    public function playlistdeleteAction()
    {
        $this->musicofmy(self::$TYPE_PLAYLIST,self::$STATUS_DELETE);
    }

    function musicofmy($type, $status)
    {
        $uinfo = $this->session->get('uinfo');
        $uid = $uinfo['_id'];
        if (!isset($uid)) $this->response->redirect('/dang-nhap.html');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        if($type == static::$TYPE_MUSIC) $limit = 10;
        else $limit = 8;

        $skip = ($p - 1) * $limit;
        $o = Users::getUserById($uid); // get namerole
        $uinfo['namerole'] = $o->namerole;
        $uinfo['is_role'] = $o->is_role;
        $timeactivity = $o->timeactivity;
        if (isset($timeactivity)) $uinfo['timeactivity'] = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo['timeactivity'] = 'Chưa cập nhật!';
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo['totalmedia'] = count($total_media); // count media
        $uinfo['totalcomment'] = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo['totallikemedia'] = $totallikemedia;
        $uinfo['totaldislikemedia'] = $totaldislikemedia;
        $data = array();
        if ($type == self::$TYPE_PLAYLIST) {
            $data = Album::findAndReturnArray(array(
                'condition' => array('usercreate' => $uinfo['_id'], 'type' => $type, 'status' => $status),
                'limit' => $limit,
                'skip' => $skip,
                'sort' => array('datecreate' => -1),
            ));
        }
        else {
            $data = Media::findAndReturnArray(array(
                'condition' => array('usercreate' => $uinfo['_id'], 'type' => $type, 'status' => $status),
                'limit' => $limit,
                'skip' => $skip,
                'sort' => array('datecreate' => -1),
            ));
        }
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            if($type == self::$TYPE_PLAYLIST) $makelink = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if($type == self::$TYPE_MUSIC) $makelink = Makelink::link_view_article_music($item['name'], $item['_id']);
            if($type == self::$TYPE_VIDEO) $makelink = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['link'] = $makelink;
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);

        }
        if ($status == self::$TYPE_PLAYLIST) $count = Album::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => $type, 'status' => $status)));
        else $count = Media::count(array('conditions' => array('usercreate' => $uinfo['_id'], 'type' => $type, 'status' => $status)));

        if($type == self::$TYPE_MUSIC) {
            $this->view->listmedia = $data;
            $title_header = 'Bài hát ';
        }
        if($type == self::$TYPE_VIDEO) {
            $this->view->listvideo = $data;
            $title_header = 'Video ';
        }
        if($type == self::$TYPE_PLAYLIST){
            $this->view->listplaylist = $data;
            $title_header = 'Playlist ';
        }
        if($status == self::$STATUS_ON) $title_status = 'đã duyệt của tôi';
        if($status == self::$STATUS_HIDDEN) $title_status  = 'chờ duyệt của tôi';
        if($status == self::$STATUS_DELETE) $title_status  = 'đã xóa của tôi';
        // validate user
        if ($uinfo['birthday'] == null || !isset($uinfo['birthday'])) $uinfo['birthday'] = "Chưa cập nhật!";
        else $uinfo['birthday'] = date('d/m/Y', $uinfo['birthday']);
        if ($uinfo['fullname'] == '') $uinfo['fullname'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == null) $uinfo['sex'] = "Chưa cập nhật!";
        if ($uinfo['facebook'] == '') $uinfo['facebook'] = "Chưa cập nhật!";
        if ($uinfo['yahoo'] == '') $uinfo['yahoo'] = "Chưa cập nhật!";
        if ($uinfo['skype'] == '') $uinfo['skype'] = "Chưa cập nhật!";
        if ($uinfo['phone'] == '') $uinfo['phone'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['address'] == '') $uinfo['address'] = "Chưa cập nhật!";
        if ($uinfo['hobby'] == '') $uinfo['hobby'] = "Chưa cập nhật!";
        if ($uinfo['sex'] == 'male') $uinfo['sex'] = 'Nam';
        else if ($uinfo['sex'] == 'female') $uinfo['sex'] = 'Nữ';
        else if ($uinfo['sex'] == 'NA') $uinfo['sex'] = 'N/A';
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->uinfo = $uinfo;
        $this->view->header = Helper::setHeader($title_header.$title_status,'', '');
    }
}

