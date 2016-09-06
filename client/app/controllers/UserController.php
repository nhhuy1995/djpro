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

class UserController extends ControllerBase
{
    public function callbackgoogleAction()
    {
        // Lấy những giá trị này từ https://console.google.com
        $client_id = $this->config->google->clientid;
        $client_secret = $this->config->google->clientsecret;
        $redirect_uri = 'http://dj.pro.vn/user/callbackgoogle';
        $client = new \Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
        $service = new \Google_Service_Oauth2($client);
        // Nếu kết nối thành công, sau đó xử lý thông tin và lưu vào database
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $userinfo = $service->userinfo->get(); //get user info
            $o = Users::findFirst(array('conditions' => array('prefix' => $userinfo->id)));
            if (isset($o->_id)) {
                $json = json_encode($o);
                $data = json_decode($json, true);
                $this->session->set('uinfo', $data);
                $this->response->redirect('/');
            } else {
                $newuser = array(
                    '_id' => strval(strtotime('now')),
                    'prefix' => $userinfo->id,
                    'username' => $userinfo->name,
                    'fullname' => $userinfo->name,
                    'email' => $userinfo->email,
                    'emaillowercase' => strtolower($userinfo->email),
                    'sex' => $userinfo->gender,
                    'priavatar' => $userinfo->picture,
                    'datecreate' => strtotime('now'),
                    'isgl' => true,
                );
                Users::insertDocument($newuser);
                if (empty($newuser['priavatar']) && !isset($newuser['priavatar'])) $newuser['priavatar'] = Helper::getAvatarUserDefault();
                $this->session->set('uinfo', $newuser);
                $this->response->redirect('/');
            }
        }
    }

    public function callbackfbAction()
    {
        $facebookAppAuthUrl = 'https://graph.facebook.com/oauth/access_token';
        $facebookGraphUrl = 'https://graph.facebook.com';
        $facebookClientId = $this->config->facebook->appid; // Put your App Id here.
        $facebookRedirectUrl = DOMAIN . '/user/callbackfb'; // Redirect url same as passed before.
        $facebookAppSecret = $this->config->facebook->appsecret; // Put your App Secret here.
        $code = $_GET['code'];

        $url = $facebookAppAuthUrl . "?client_id=" . $facebookClientId
            . "&redirect_uri=" . $facebookRedirectUrl
            . "&client_secret=" . $facebookAppSecret
            . "&code=" . $code;
        $output = Helper::urlResponse($url);
        // Get access token
        $access_token = str_replace('access_token=', '', explode("&", $output)[0]);
        $url = $facebookGraphUrl . '/me';
        $tmp = Helper::processUrl($url, $access_token);
        //user info
        $userinfo = json_decode($tmp);
        $avatar = $facebookGraphUrl . '/' . $userinfo->id . '/picture?type=large';
        if (isset($userinfo->id)) {
            $o = Users::findFirst(array('conditions' => array('prefix' => $userinfo->id)));
            if (isset($o->_id)) {
                $json = json_encode($o);
                $data = json_decode($json, true);
                $this->session->set('uinfo', $data);
                return $this->response->redirect('/');
            } else {
                $newuser = array(
                    '_id' => strval(strtotime('now')),
                    'prefix' => $userinfo->id,
                    'username' => $userinfo->name,
                    'fullname' => $userinfo->name,
                    'email' => $userinfo->email,
                    'emaillowercase' => strtolower($userinfo->email),
                    'priavatar' => $avatar,
                    'datecreate' => strtotime('now'),
                    'isfb' => true,
                );
                Users::insertDocument($newuser);
                if (empty($newuser['priavatar']) && !isset($newuser['priavatar'])) $newuser['priavatar'] = Helper::getAvatarUserDefault();
                $this->session->set('uinfo', $newuser);
                return $this->response->redirect('/');
            }
        } else return $this->response->redirect('/');
    }

    public function memberAction()
    {
        $type = $this->request->get('t');
        $uid = $this->dispatcher->getParam('uid');
        if (isset($type)) {
            if ($type == static::$TYPE_MUSIC) $action = 'memberaudio';
            if ($type == static::$TYPE_PLAYLIST) $action = 'memberplaylist';
            if ($type == static::$TYPE_VIDEO) $action = 'membervideo';
            $this->dispatcher->forward(
                array('controller' => 'user',
                    'action' => $action,
                ));
        }
        $uinfo = Users::getUserById($uid);
        $uinfo->link = Makelink::link_view_member($uinfo->username, $uinfo->getId());
        $timeactivity = $uinfo->timeactivity;
        if (isset($timeactivity)) $uinfo->timeactivity = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo->timeactivity = 'Chưa cập nhật!';
        if (isset($timeactivity)) { // check and update time online
            $checktime_online = ceil((strtotime(date('H:i:s')) - strtotime(date('H:i:s', $timeactivity))) / 60);
            if ($checktime_online >= 30) Users::updateDocument(array('condition' => array('_id' => $uid)), array('$set' => array('isonline' => 0)));
        }
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo->totalmedia = count($total_media); // count media
        $uinfo->totalcomment = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo->totallikemedia = $totallikemedia;
        $uinfo->totaldislikemedia = $totaldislikemedia;
        if (!isset($uinfo)) $this->response->redirect('/dang-nhap.html');
        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON),
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
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON),
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
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_ON),
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
//        if ($uinfo->birthday == null || !isset($uinfo->birthday)) $uinfo->birthday = "Chưa cập nhật!";
//        else $uinfo->birthday = date('d/m/Y', $uinfo->birthday);
        if ($uinfo->fullname == '') $uinfo->fullname = "Chưa cập nhật!";
        if ($uinfo->sex == null) $uinfo->sex = "Chưa cập nhật!";
        if ($uinfo->facebook == '') $uinfo->facebook = "Chưa cập nhật!";
        if ($uinfo->yahoo == '') $uinfo->yahoo = "Chưa cập nhật!";
        if ($uinfo->skype == '') $uinfo->skype = "Chưa cập nhật!";
        if ($uinfo->phone == '') $uinfo->phone = "Chưa cập nhật!";
        if ($uinfo->address == '') $uinfo->address = "Chưa cập nhật!";
        if ($uinfo->job == '') $uinfo->job = "Chưa cập nhật!";
        if ($uinfo->hobby == '') $uinfo->hobby = "Chưa cập nhật!";
        if ($uinfo->sex == 'male') $uinfo->sex = 'Nam';
        else if ($uinfo->sex == 'female') $uinfo->sex = 'Nữ';
        else if ($uinfo->sex == 'NA') $uinfo->sex = 'N/A';
        $this->view->listplaylist = $data;
        $this->view->uinfo = $uinfo;
        $this->view->countaudio = Media::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON)));
        $this->view->countvideo = Media::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON)));
        $this->view->countplaylist = Album::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_ON)));
        $this->view->header = Helper::setHeader("Thành viên - " . $uinfo->username, '', '');
    }

    public function memberplaylistAction()
    {
        $uid = $this->dispatcher->getParam('uid');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $uinfo = Users::getUserById($uid);
        $uinfo->link = Makelink::link_view_member($uinfo->username, $uinfo->getId());
        $timeactivity = $uinfo->timeactivity;
        if (isset($timeactivity)) $uinfo->timeactivity = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo->timeactivity = 'Chưa cập nhật!';
        if (isset($timeactivity)) { // check and update time online
            $checktime_online = ceil((strtotime(date('H:i:s')) - strtotime(date('H:i:s', $timeactivity))) / 60);
            if ($checktime_online >= 30) Users::updateDocument(array('condition' => array('_id' => $uid)), array('$set' => array('isonline' => 0)));
        }
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo->totalmedia = count($total_media); // count media
        $uinfo->totalcomment = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo->totallikemedia = $totallikemedia;
        $uinfo->totaldislikemedia = $totaldislikemedia;

        //list playlist
        $listPlaylist = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_PLAYLIST, 'status' => self::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listPlaylist as &$item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        $count = Album::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_PLAYLIST)));
        $this->view->listplaylist = $listPlaylist;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        // validate user
        if ($uinfo->birthday == null || !isset($uinfo->birthday)) $uinfo->birthday = "Chưa cập nhật!";
        else $uinfo->birthday = date('d/m/Y', $uinfo->birthday);
        if ($uinfo->fullname == '') $uinfo->fullname = "Chưa cập nhật!";
        if ($uinfo->sex == null) $uinfo->sex = "Chưa cập nhật!";
        if ($uinfo->facebook == '') $uinfo->facebook = "Chưa cập nhật!";
        if ($uinfo->yahoo == '') $uinfo->yahoo = "Chưa cập nhật!";
        if ($uinfo->skype == '') $uinfo->skype = "Chưa cập nhật!";
        if ($uinfo->phone == '') $uinfo->phone = "Chưa cập nhật!";
        if ($uinfo->address == '') $uinfo->address = "Chưa cập nhật!";
        if ($uinfo->job == '') $uinfo->job = "Chưa cập nhật!";
        if ($uinfo->hobby == '') $uinfo->hobby = "Chưa cập nhật!";
        if ($uinfo->sex == 'male') $uinfo->sex = 'Nam';
        else if ($uinfo->sex == 'female') $uinfo->sex = 'Nữ';
        else if ($uinfo->sex == 'NA') $uinfo->sex = 'N/A';
        $this->view->uinfo = $uinfo;
        $this->view->header = Helper::setHeader("Thành viên - " . $uinfo->username, '', '');
    }

    public function membervideoAction()
    {
        $uid = $this->dispatcher->getParam('uid');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $uinfo = Users::getUserById($uid);
        $uinfo->link = Makelink::link_view_member($uinfo->username, $uinfo->getId());
        $timeactivity = $uinfo->timeactivity;
        if (isset($timeactivity)) $uinfo->timeactivity = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo->timeactivity = 'Chưa cập nhật!';
        if (isset($timeactivity)) { // check and update time online
            $checktime_online = ceil((strtotime(date('H:i:s')) - strtotime(date('H:i:s', $timeactivity))) / 60);
            if ($checktime_online >= 30) Users::updateDocument(array('condition' => array('_id' => $uid)), array('$set' => array('isonline' => 0)));
        }
        $total_media = Media::findAndReturnArray(array('condition' => array('usercreate' => $uid)));
        $uinfo->totalmedia = count($total_media); // count media
        $uinfo->totalcomment = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo->totallikemedia = $totallikemedia;
        $uinfo->totaldislikemedia = $totaldislikemedia;

        //list video
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listVideo as &$item) {
            $artistid = $item['artist'];
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarVideoDefault();
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        $count = Media::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_VIDEO, 'status' => self::$STATUS_ON)));
        $this->view->listvideo = $listVideo;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        // validate user
        if ($uinfo->birthday == null || !isset($uinfo->birthday)) $uinfo->birthday = "Chưa cập nhật!";
        else $uinfo->birthday = date('d/m/Y', $uinfo->birthday);
        if ($uinfo->fullname == '') $uinfo->fullname = "Chưa cập nhật!";
        if ($uinfo->sex == null) $uinfo->sex = "Chưa cập nhật!";
        if ($uinfo->facebook == '') $uinfo->facebook = "Chưa cập nhật!";
        if ($uinfo->yahoo == '') $uinfo->yahoo = "Chưa cập nhật!";
        if ($uinfo->skype == '') $uinfo->skype = "Chưa cập nhật!";
        if ($uinfo->phone == '') $uinfo->phone = "Chưa cập nhật!";
        if ($uinfo->address == '') $uinfo->address = "Chưa cập nhật!";
        if ($uinfo->job == '') $uinfo->job = "Chưa cập nhật!";
        if ($uinfo->hobby == '') $uinfo->hobby = "Chưa cập nhật!";
        if ($uinfo->sex == 'male') $uinfo->sex = 'Nam';
        else if ($uinfo->sex == 'female') $uinfo->sex = 'Nữ';
        else if ($uinfo->sex == 'NA') $uinfo->sex = 'N/A';
        $this->view->uinfo = $uinfo;
        $this->view->header = Helper::setHeader("Thành viên - " . $uinfo->username, '', '');
    }

    public function memberaudioAction()
    {
        $uid = $this->dispatcher->getParam('uid');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $uinfo = Users::getUserById($uid);
        $uinfo->link = Makelink::link_view_member($uinfo->username, $uinfo->getId());
        $timeactivity = $uinfo->timeactivity;
        if (isset($timeactivity)) $uinfo->timeactivity = Helper::get_time_ago($timeactivity); // time activity
        else $uinfo->timeactivity = 'Chưa cập nhật!';
        $total_media = Media::count(array('usercreate' => $uid));
        $uinfo->totalmedia = $total_media; // count media
        $uinfo->totalcomment = count(Comment::findAndReturnArray(array('condition' => array('user_id' => $uid)))); // count comment
        //list id media
        foreach ($total_media as $item) $listidmedia[] = $item['_id'];
        $totallikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_LIKE)))) : 0;
        $totaldislikemedia = isset($listidmedia) ? count(Notify::findAndReturnArray(array('condition' => array('atid' => array('$in' => $listidmedia), 'type' => static::$OPTION_TYPE_DISLIKE)))) : 0;
        $uinfo->totallikemedia = $totallikemedia;
        $uinfo->totaldislikemedia = $totaldislikemedia;

        //list media
        $listMedia = Media::findAndReturnArray(array(
            'condition' => array('usercreate' => $uid, 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMedia as $item) {
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::count(array('conditions' => array('usercreate' => $uid, 'type' => self::$TYPE_MUSIC, 'status' => self::$STATUS_ON)));
        $this->view->listmedia = $data;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        // validate user
        if ($uinfo->birthday == null || !isset($uinfo->birthday)) $uinfo->birthday = "Chưa cập nhật!";
        else $uinfo->birthday = date('d/m/Y', $uinfo->birthday);
        if ($uinfo->fullname == '') $uinfo->fullname = "Chưa cập nhật!";
        if ($uinfo->sex == null) $uinfo->sex = "Chưa cập nhật!";
        if ($uinfo->facebook == '') $uinfo->facebook = "Chưa cập nhật!";
        if ($uinfo->yahoo == '') $uinfo->yahoo = "Chưa cập nhật!";
        if ($uinfo->skype == '') $uinfo->skype = "Chưa cập nhật!";
        if ($uinfo->phone == '') $uinfo->phone = "Chưa cập nhật!";
        if ($uinfo->address == '') $uinfo->address = "Chưa cập nhật!";
        if ($uinfo->job == '') $uinfo->job = "Chưa cập nhật!";
        if ($uinfo->hobby == '') $uinfo->hobby = "Chưa cập nhật!";
        if ($uinfo->sex == 'male') $uinfo->sex = 'Nam';
        else if ($uinfo->sex == 'female') $uinfo->sex = 'Nữ';
        else if ($uinfo->sex == 'NA') $uinfo->sex = 'N/A';
        $this->view->uinfo = $uinfo;
        $this->view->header = Helper::setHeader("Thành viên - " . $uinfo->username, '', '');
    }

    public function loginAction()
    {
        $this->response->redirect('/');
        $username = $this->request->get('username');
        $password = $this->request->get('password');
        $password_encryp = Helper::encryptpassword($password);
        if ($this->request->isPost()) {
            $condition['$and'] = array(
                array('$or' => array(
                    array('usernamelowercase' => strtolower($username)),
                    array('emaillowercase' => strtolower($username))
                )),
                array('password' => $password_encryp)
            );
            $userInfo = Users::findFirst(array(
                'fields' => array('_id', 'username', 'password', 'email', 'priavatar'),
                'conditions' => $condition,
            ));
            if ($userInfo) {
                if (empty($userInfo->priavatar) && !isset($userInfo->priavatar)) $userInfo->priavatar = Helper::getAvatarUserDefault();
                $userInfo->isonline = 1;
                $this->session->set('uinfo', (array)$userInfo);
                $this->response->redirect("/");
            } else $msg = 'Không tìm thấy tài khoản hợp lệ';
        }
        $this->view->msg = $msg;
        $this->view->header = Helper::setHeader('Đăng nhập', '', '');
    }

    public function registerAction()
    {
        $username = $this->request->get('name');
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $repassword = $this->request->get('re-password');
        $capcha = $this->request->get('capcha');
        $capcha_generate = $this->request->get('capcha-random');
        if ($this->request->isPost()) {
            if (!empty($username) || !empty($email) || !empty($password)) {
                if ($password == $repassword) {
                    if ($capcha == $capcha_generate) {
                        //check user
                        $userInfo_where_username = Users::findFirst(array('conditions' => array('usernamelowercase' => strtolower($username))));
                        $userInfo_where_email = Users::findFirst(array('conditions' => array('emaillowercase' => strtolower($email))));
                        if ($userInfo_where_username) $msg = 'Tài khoản này đã tồn tại!';
                        else if ($userInfo_where_email) $msg = 'Email này đã tồn tại!';
                        else {
                            //save user
                            $newuser = array(
                                '_id' => strval(strtotime('now')),
                                'username' => $username,
                                'usernamelowercase' => strtolower($username),
                                'emaillowercase' => strtolower($email),
                                'email' => $email,
                                'password' => Helper::encryptpassword($password),
                                'datecreate' => strtotime('now'),
                            );
                            Users::insertDocument($newuser);
                            $newuser['isonline'] = 1;
                            $this->session->set('uinfo', $newuser);
                            return $this->response->redirect('/');
                        }

                    } else $msg = 'Mã capcha không đúng';
                } else $msg = 'Mật khẩu không trùng khớp!';
            } else $msg = 'Vui lòng điền đẩy đủ thông tin!';
        }
        $this->view->msg = $msg;
        $this->view->header = Helper::setHeader('Đăng ký tài khoản', '', '');
    }

    public function changepasswordAction()
    {
        $uinfo = $this->session->get('uinfo');
        if (!isset($uinfo)) $this->response->redirect('/dang-nhap.html');
        //Process
        $passwordcurrent = $this->request->get('passwordcurrent');
        $password = $this->request->get('password');
        $repassword = $this->request->get('repassword');
        $uinfo = $this->session->get('uinfo');
        if ($this->request->isPost()) {
            $passwordcurrent_encrypt = Helper::encryptpassword($passwordcurrent);
            $password_encrypt = Helper::encryptpassword($password);
            if ($passwordcurrent_encrypt == $uinfo['password']) {
                if (strlen($password) >= 6) {
                    if (!empty($password) || !empty($repassword)) {
                        if ($password == $repassword) {
                            Users::updateDocument(array('_id' => $uinfo['_id']), array('$set' => array('password' => $password_encrypt)));
                            $msg = array('msg' => 'Đổi mật khẩu thành công!', 'status' => 1);
                        } else $msg = array('msg' => 'Mật khẩu mới không khớp nhau!', 'status' => 0);
                    } else $msg = array('msg' => 'Mật khẩu mới ko không bỏ trống!', 'status' => 0);
                } else $msg = array('msg' => 'Mật khẩu mới phải từ 6 kí tự trở lên!', 'status' => 0);
            } else $msg = array('msg' => 'Mật khẩu hiện tại không đúng', 'status' => 0);
        }
        $this->view->msg = $msg;
        $this->view->header = Helper::setHeader('Đổi mật khẩu', '', '');
    }

    public function forgotpasswordAction()
    {
        $this->response->redirect('/');
        $email = $this->request->get('email');
        if ($this->request->isPost()) {
            $o = Users::findFirst(array('conditions' => array('emaillowercase' => strtolower($email))));
            if ($o->_id) {
                $userid = $o->_id;
                $token_key = md5(md5(time() . $userid . rand(1000, 9999)));
                $subject = "Lấy lại mật khẩu dj.pro.vn";
                $content = "<a href='http://dj.pro.vn/khoi-phuc-mat-khau.html?token=$token_key'>Click vào đây để lấy lại mật khẩu.</a>";
                Email::sendMail($subject, $email, $content);
                $newtoken = array(
                    "_id" => strval(time()),
                    "datecreate" => strtotime('now'),
                    "userid" => $userid,
                    "token" => $token_key,
                    "status" => 1,
                );
                Token_key::insertDocument($newtoken);
                $msg = array('status' => 1, 'msg' => "Chúng tôi đã gửi link lấy lại mật khẩu vào email của bạn, vui lòng check lại email");
            } else {
                $msg = array('status' => 0, 'msg' => "Email này ko tồn tại trong hệ thống!");
            }
        }
        $this->view->error = $msg;
        $this->view->header = Helper::setHeader('Quên mật khẩu', '', '');
    }

    public function resetpasswordAction()
    {
        $token = $_GET['token'];
        if (!isset($token)) $this->response->redirect('quen-mat-khau.html');
        $password = $this->request->get('password');
        $repassword = $this->request->get('re-password');
        if ($this->request->isPost()) {
            if (strlen($password) < 6) $msg = array('status' => 0, 'msg' => "Mật khẩu phải từ 6 kí tự trở lên");
            else if ($password != $repassword) $msg = array('status' => 0, 'msg' => "Mật khẩu không khớp nhau!");
            else {
                $password_encryp = Helper::encryptpassword($password);
                $o = Token_key::findFirst(array("conditions" => array('token' => $token)));
                if ($o->_id) {
                    $userid = $o->userid;
                    Users::updateDocument(array('_id' => $userid), array('$set' => array('password' => $password_encryp)));
                    Token_key::deleteDocument(array('_id' => $o->_id));
                    $msg = array('status' => 1, 'msg' => "Khôi phục mật khẩu thành công. Click vào <a href='/' style='color:blue;'>đây</a> để về trang chủ");
                } else $msg = array('status' => 0, 'msg' => "Mã token không hợp lệ hoặc đã hết hạn!");
            }
        }
        $this->view->setVars(array(
            'error' => $msg,
        ));
        $this->view->header = Helper::setHeader('Khôi phục mật khẩu', '', '');
    }

    public function logoutAction()
    {
        $uinfo = $this->session->get('uinfo');
        Users::updateDocument(array('_id' => $uinfo['_id']), array('$set' => array('isonline' => 0)));
        $redirect = $this->request->getHTTPReferer();
        $this->session->destroy();
        $this->response->redirect($redirect);
    }

    public function uploadAction()
    {
        $this->response->redirect('/');
        $uinfo = $this->session->get('uinfo');
        if (!isset($uinfo)) $this->response->redirect('/dang-nhap.html');
        $name = $this->request->get('name');
        $artist = $this->request->get('artist');
        $mediaurl = $this->request->get('mediaurl');
        $category = $this->request->get('category');
        $type = $this->request->get('type');
        $linkType = $this->request->get('linkType');
        $content = $this->request->get('content');
        $uinfo = $this->session->get('uinfo');
        if ($this->request->isPost()) {
            if (empty($name)) $msg = array('status' => 0, 'msg' => 'Tên bài hát không được bỏ trống!');
            else if (empty($name)) $msg = array('status' => 0, 'msg' => 'Link nhạc không được bỏ trống!');
            else if (empty($type)) $msg = array('status' => 0, 'msg' => 'Vui lòng chọn thể loại nhạc!');
            else {
                $newMedia = array(
                    '_id' => strval(strtotime('now')),
                    'name' => $name,
                    'content' => $content,
                    'category' => array($category),
                    'mediaurl' => $mediaurl,
                    'artist' => $artist,
                    'status' => 0,
                    'type' => $type,
                    'datecreate' => strtotime('now'),
                    'usercreate' => $uinfo['_id'],
                    'namenonutf' => Helper::convertToUtf8($name),
                );
                Media::insertDocument($newMedia);
                $msg = array('status' => 1, 'msg' => 'Đăng nhạc thành công!');
            }
        }
        $this->view->msg = $msg;
        $this->view->title = 'Đăng nhạc';
    }

    public function playlistAction()
    {
        $uinfo = $this->session->get('uinfo');
        if (!isset($uinfo)) $this->response->redirect('/dang-nhap.html');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listPlaylist = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id']),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listPlaylist as $item) {
            if (!isset($item['priavatar'])) $item['priavatar'] = '/web/images/avatar_playlist.jpg';
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('condition' => array('usercreate' => $uinfo['_id'])),
        ));
        $this->breadCrumbs->addItem(array('name' => "Playlist của tôi", 'link' => "/playlist-cua-toi.html"), static::$TYPE_PLAYLIST);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listplaylist = $data;
        $this->view->header = Helper::setHeader('Playlist của tôi', '', '');
    }

    public function updateinfoAction()
    {
        $uinfo = $this->session->get('uinfo');
        if (!isset($uinfo['_id'])) $this->response->redirect('/');
        $o = Users::findById($uinfo['_id']);
        if ($o->birthday == null || !isset($o->birthday)) {
            $o->birthday = strtotime('now');
        }
        if ($this->request->isPost()) {
            $fullname = $this->request->get('fullname');
            $address = $this->request->get('address');
            $phone = $this->request->get('phone');
            $facebook = $this->request->get('facebook');
            $yahoo = $this->request->get('yahoo');
            $skype = $this->request->get('skype');
            $job = $this->request->get('job');
            $hobby = $this->request->get('hobby');
            $days = intval($this->request->get('days'));
            $month = intval($this->request->get('month'));
            $year = intval($this->request->get('year'));
            $sex = $this->request->get('sex');
            $priavatar = $this->request->get('priavatar');
            $updateinfo = array(
                'fullname' => $fullname,
                'address' => $address,
                'phone' => $phone,
                'days' => $days,
                'month' => $month,
                'year' => $year,
                'facebook' => $facebook,
                'yahoo' => $yahoo,
                'job' => $job,
                'hobby' => $hobby,
                'skype' => $skype,
                'sex' => $sex,
                'priavatar' => $priavatar,
            );
            $user = Users::getCollectionInstance()->findAndModify(array('_id' => $o->getId()), array('$set' => $updateinfo));
            $_SESSION['uinfo']['priavatar'] = $priavatar;
            $o = Users::findById($uinfo['_id']);
            $msg = array('status' => 1, 'msg' => 'Cập nhật thông tin thành công!');
        }
        if (empty($o->priavatar) || !isset($o->priavatar)) $o->priavatar = Helper::getAvatarUserDefault();
        $this->view->setVars(array(
            'object' => $o,
            'msg' => $msg,
        ));
        $this->view->header = Helper::setHeader('Đổi thông tin cá nhân', '', '');
    }
}

