<?php
namespace DjClient\Controller;

use DjClient\Library\ArticleDetail\ArticleDetail;
use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Feedback;
use DjClient\Models\Media;
use DjClient\Models\MediaRequire;
use DjClient\Models\Notify;
use DjClient\Models\Token_key;
use DjClient\Models\Users;
use DjClient\Services\Email;
use DjClient\Services\RankingArticle;

class IncomingController extends ControllerBase
{
    public function getuserbyarticleAction()
    {
        $id = $this->request->get('id');
        $article_type = $this->request->get('article_type');
        $type = $this->request->get('type');
        $listUser = array();
        $listdata = Notify::findAndReturnArray(array(
            'condition' => array('atid' => $id, 'article_type' => $article_type, 'type' => $type),
        ));
        if (!empty($listdata)) {
            foreach ($listdata as $item) $listIdUser[] = $item['userid'];
            $listUser = Users::findAndReturnArray(array(
                'fields' => array('_id', 'username', 'email', 'priavatar'),
                'condition' => array('_id' => array('$in' => $listIdUser))
            ));
            foreach ($listUser as $key => $item) {
                $listUser[$key]['link'] = Makelink::link_view_member($item['username'], $item['_id']);
                if (empty($item['priavatar']) || !isset($item['priavatar'])) $listUser[$key]['priavatar'] = Helper::getAvatarUserDefault();
            }
        }
        $dtr['status'] = 200;
        $dtr['msg'] = 'Successfuly';
        $dtr['data'] = $listUser;
        $dtr['total'] = count($listdata);
        Helper::jsonResponse($dtr);
    }

    public function forgotpasswordAction()
    {
        $email = $this->request->get('email');

        if (strlen($email) < 1) $dtr = array('status' => 300, 'msg' => "Vui lòng nhập email của bạn!");
        else {
            $o = Users::findFirst(array('conditions' => array('email' => $email)));
            if (isset($o->_id)) {
                $userid = $o->_id;
                $token_key = md5(md5(time() . $userid . rand(1000, 9999)));
                $subject = "Lấy lại mật khẩu Dj.pro.vn";
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
                $dtr = array('status' => 200, 'msg' => "Chúng tôi đã gửi link lấy lại mật khẩu vào email của bạn, vui lòng check lại email");
                die(123);
            } else {
                $dtr = array('status' => 300, 'msg' => "Email này ko tồn tại trong hệ thống!");
            }
        }

        Helper::jsonResponse($dtr);
    }

    public function getlyricAction()
    {
        $id = $this->request->get('id');
        $object = Media::findById($id);
        // Get Sym link media
        Media::getSymLinkMedia($object);
        $object = (array)$object;

        $object['link'] = Makelink::link_view_article_music($object['name'], $object['_id']);
        $object["userinfo"] = Users::getUserById($object['usercreate']);
        if ($object) {
            $dtr['status'] = 200;
            $dtr['data'] = $object;
            $dtr['msg'] = 'Successfuly!';
        } else {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Failed';
        }
        Helper::jsonResponse($dtr);
    }

    public function checknamemediaAction()
    {
        $name = strtolower(Helper::convertToUtf8($this->request->get('name')));
        $o = Media::findFirst(array('conditions' => array('namenonutf' => $name)));
        if (strlen($name) > 200) $msg = array('status' => 300, 'msg' => 'Tên bài hát không được vượt quá 200 kí tự!');
        else {
            if ($o->_id) $msg = array('status' => 300, 'msg' => 'Tên bài hát đã tồn tại!');
            else $msg = array('status' => 200, 'msg' => 'Ok!');
        }

        Helper::jsonResponse($msg);
    }

    public function checklinktypeAction()
    {
        $link = $this->request->get('link');
        $type = $this->request->get('type');
        $exten = Helper::CheckExtention($link);
        if (empty($link)) $msg = array('status' => 300, 'msg' => 'Vui lòng nhập link nhạc!');
        else {
            if ($exten != $type) $msg = array('status' => 300, 'msg' => 'Dạng link không đúng, vui lòng chọn lại!');
            else $msg = array('status' => 200, 'msg' => 'Ok!');
        }
        Helper::jsonResponse($msg);
    }

    public function checkcategoryAction()
    {
        $category = $this->request->get('category');
        $type = $this->request->get('type');
        $catInfo = Category::findById($category);
        if ($type != $catInfo->type) $msg = array('status' => 300, 'msg' => 'Chuyên mục bạn đăng không đúng với thể loại bạn đăng!');
        else $msg = array('status' => 200, 'msg' => 'Ok!');
        Helper::jsonResponse($msg);
    }

    public function uploadmusicAction()
    {
        $uinfo = $this->session->get('uinfo');
        $name = strip_tags($this->request->get('name'));
        $artist = $this->request->get('artist');
        $mediaurl = strip_tags($this->request->get('mediaurl'));
        $category = $this->request->get('category');
        $type = $this->request->get('type');
        $linkType = $this->request->get('linkType');
        $content = strip_tags(nl2br($this->request->get('content')));
        $capcha = $_POST['capcha'];
        $capcha_generate = $_POST['capcha-random'];
        $uinfo = $this->session->get('uinfo');
        $name_convert = strtolower(Helper::convertToUtf8($name));
        $o = Media::findFirst(array('conditions' => array('namenonutf' => $name_convert)));
        $catInfo = Category::findById($category);
        $exten = Helper::CheckExtention($mediaurl);
        if (strlen($name) > 200) $msg = array('status' => 300, 'msg' => 'Tên bài hát không được vượt quá 200 kí tự!');
        else if ($o->_id) $msg = array('status' => 300, 'msg' => 'Tên bài hát đã tồn tại!');
        else {
            if (empty($name)) $msg = array('status' => 300, 'msg' => 'Tên bài hát không được bỏ trống!');
            else if (empty($artist[0])) $msg = array('status' => 300, 'msg' => 'Vui lòng nhập DJ thể hiện!');
            else if (empty($mediaurl)) $msg = array('status' => 300, 'msg' => 'Vui lòng nhập link nhạc!');
            else if (empty($category) || !isset($category)) $msg = array('status' => 300, 'msg' => 'Chuyên mục không được bỏ trống!');
            else if (empty($type)) $msg = array('status' => 300, 'msg' => 'Vui lòng chọn thể loại nhạc!');
            else if ($exten != $linkType) $msg = array('status' => 300, 'msg' => 'Dạng link không đúng, vui lòng chọn lại!');
            else if ($catInfo->type != $type) $msg = array('status' => 300, 'msg' => 'Chuyên mục bạn đăng không đúng với thể loại bạn đăng!');
            else if (empty($capcha)) $msg = array('status' => 300, 'msg' => 'Vui lòng nhập mã bảo mật!');
            else if ($capcha != $capcha_generate) $msg = array('status' => 300, 'msg' => 'Mã bảo mật không đúng!');
            else {

                if (isset($artist) && !empty($artist)) {
                    $artist = Artist::standardListArtist($artist, $uinfo['_id'], Artist::$_STATUS_WAIT);
                }

                $newMedia = array(
                    '_id' => strval(strtotime('now')),
                    'name' => $name,
                    'content' => $content,
                    'category' => array($category),
                    'mediaurl' => $mediaurl,
                    'artist' => $artist,
                    'status' => static::$STATUS_HIDDEN,
                    'type' => $type,
                    'datecreate' => strtotime('now'),
                    'usercreate' => $uinfo['_id'],
                    'namenonutf' => Helper::convertToUtf8($name),
                    'direct_media_url' => ArticleDetail::getMediaUrl($mediaurl, $this->config->application->baseFrontendUri),
                );
                Media::insertDocument($newMedia);
                $msg = array('status' => 200, 'msg' => 'Đăng nhạc thành công. Bạn vui lòng chờ BQT duyệt!');
            }
        }
        Helper::jsonResponse($msg);
    }

    public function requiremusicAction()
    {
        $uinfo = $this->session->get('uinfo');
        $name = strip_tags($this->request->get('name'));
        $artist = $this->request->get('artist');
        $category = $this->request->get('category');
        $type = $this->request->get('type');
        $content = nl2br($this->request->get('content'));
        $capcha = $_POST['capcha'];
        $capcha_generate = $_POST['capcha-random'];
        $uinfo = $this->session->get('uinfo');
        $name_convert = strtolower(Helper::convertToUtf8($name));
        $o = MediaRequire::findFirst(array('conditions' => array('namenonutf' => $name_convert)));
        $catInfo = Category::findById($category);
        if (strlen($name) > 200) $msg = array('status' => 300, 'msg' => 'Tên bài hát không được vượt quá 200 kí tự!');
        else if ($o->_id) $msg = array('status' => 300, 'msg' => 'Tên bài hát đã tồn tại!');
        else {
            if (empty($name)) $msg = array('status' => 300, 'msg' => 'Tên bài hát không được bỏ trống!');
            else if (empty($category) || !isset($category)) $msg = array('status' => 300, 'msg' => 'Chuyên mục không được bỏ trống!');
            else if (empty($type)) $msg = array('status' => 300, 'msg' => 'Vui lòng chọn thể loại nhạc!');
            else if ($catInfo->type != $type) $msg = array('status' => 300, 'msg' => 'Chuyên mục bạn đăng không đúng với thể loại bạn đăng!');
            else if (empty($capcha)) $msg = array('status' => 300, 'msg' => 'Vui lòng nhập mã bảo mật!');
            else if ($capcha != $capcha_generate) $msg = array('status' => 300, 'msg' => 'Mã bảo mật không đúng!');
            else {
                if (isset($artist) && !empty($artist)) {
                    $artist = Artist::standardListArtist($artist, $uinfo['_id'], Artist::$_STATUS_WAIT);
                }
                $newMedia = array(
                    '_id' => strval(strtotime('now')),
                    'name' => $name,
                    'content' => $content,
                    'category' => array($category),
                    'artist' => $artist,
                    'status' => static::$STATUS_HIDDEN,
                    'type' => $type,
                    'datecreate' => strtotime('now'),
                    'usercreate' => $uinfo['_id'],
                    'namenonutf' => Helper::convertToUtf8($name),
                );
                MediaRequire::insertDocument($newMedia);
                $msg = array('status' => 200, 'msg' => 'Gửi yêu cầu thành công. Bạn vui lòng chờ BQT duyệt!');
            }
        }
        Helper::jsonResponse($msg);
    }

    public function loginAction()
    {
//        ini_set('display_errors', true);
//        error_reporting(E_ALL);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $condition['$and'] = array(
            array('$or' => array(
                array('usernamelowercase' => strtolower($username)),
                array('emaillowercase' => strtolower($username))
            )),
            array('password' => $password)
        );
        if (strlen($username) < 1) {
            $dtr['status'] = 300;
            $dtr['msg'] = "Vui lòng nhập đầy đủ thông tin!";
        } else {
            $userInfo = Users::findFirst(array(
                'fields' => array('_id', 'username', 'password', 'facebook', 'yahoo', 'skype', 'days', 'month', 'year', 'email', 'priavatar', 'datecreate', 'fullname', 'job', 'address', 'phone', 'birthday', 'sex', 'isonline', 'timeactivity'),
                'conditions' => $condition,
            ));
            $checkusername = Users::findFirst(array(
                'fields' => array('_id', 'username', 'password', 'email', 'priavatar'),
                'conditions' => array('$or' => array(
                    array('usernamelowercase' => strtolower($username)),
                    array('emaillowercase' => strtolower($username)))),
            ));
            if ($checkusername) $msg = "Mật khẩu không hợp lệ!";
            else $msg = "Không tìm thấy tài khoản hợp lệ!";

            if (isset($userInfo->_id)) {
                $timecurrent = intval(strtotime('now'));// set time activity
                Users::updateDocument(array('_id' => $userInfo->_id), array('$set' => array('isonline' => 1, 'timeactivity' => $timecurrent)));
                $userInfo->isonline = 1;
                $userInfo->timeactivity = $timecurrent;
                if (empty($userInfo->priavatar) || !isset($userInfo->priavatar)) $userInfo->priavatar = Helper::getAvatarUserDefault();
                $userInfo = get_object_vars($userInfo);
                $this->session->set('uinfo', $userInfo);
                $dtr['status'] = 200;
                $dtr['msg'] = "Đăng nhập thành công!";
            } else {
                $dtr['status'] = 300;
                $dtr['msg'] = $msg;
            }
        }
        Helper::jsonResponse($dtr);
    }

    public function registerAction()
    {

        $username = strip_tags($this->request->get('name'));
        $fullname = strip_tags($this->request->get('fullname'));
        $email = strip_tags($this->request->get('email'));
        $password = strip_tags($this->request->get('password'));
        $repassword = strip_tags($this->request->get('repassword'));
        $days = $this->request->get('days');
        $month = $this->request->get('month');
        $year = $this->request->get('year');
        $sex = $this->request->get('sex');
        $capcha = $this->request->get('capcha');
        $capcha_generate = $this->request->get('capcha-random');
        $password_encrypt = Helper::encryptpassword($password);
        $randomString = Helper::RandomString(5);
        $usernameInfo = Users::findFirst(array('conditions' => array('usernamelowercase' => strtolower($username))));
        $emailInfo = Users::findFirst(array('conditions' => array('emaillowercase' => strtolower($email))));
        if (strlen($username) < 5) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Username phải từ 5 kí tự trở lên!';
        } else if ($usernameInfo) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Username này đã tồn tại!';
        } else if (empty($fullname)) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Họ và tên không được bỏ trống!';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Email không hợp lệ!';
        } else if ($emailInfo) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Email này đã tồn tại!';
        } else if (strlen($password) < 6) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Mật khẩu phải lớn hơn 6 kí tự!';
        } else if ($password != $repassword) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Mật khẩu không trùng khớp!';
        } else if (empty($days) || empty($month) || empty($year)) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Vui lòng chọn đầy đủ ngày,tháng,năm sinh!';
        } else if ($capcha != $capcha_generate) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Mã bảo mật không đúng!';
        } else {
            //save user
            $newuser = array(
                '_id' => strval(strtotime('now')),
                'username' => $username,
                'fullname' => $fullname,
                'usernamelowercase' => strtolower($username),
                'emaillowercase' => strtolower($email),
                'email' => $email,
                'password' => $password_encrypt,
                'days' => $days,
                'month' => $month,
                'year' => $year,
                'sex' => $sex,
                'datecreate' => strtotime('now'),
            );
            Users::insertDocument($newuser);
            $newuser['isonline'] = 1;
            $this->session->set('uinfo', $newuser);
            $_SESSION['uinfo']['priavatar'] = Helper::getAvatarUserDefault();
            $dtr['status'] = 200;
            $dtr['msg'] = 'Chúc mừng bạn đăng ký thành công!';
        }
        $dtr['randomstring'] = $randomString;
        echo Helper::jsonResponse($dtr);
    }

    public function sendfeedbackAction()
    {
        $content = $this->request->get('content');
        $atid = $this->request->get('atid');
        $type = $this->request->get('type');
        $uinfo = $this->session->get('uinfo');
        $cookie_key = 'fb_' . $atid . '_' . $type;
        if ($this->cookies->has($cookie_key)) {
            $dtr['status'] = 300;
            $dtr['msg'] = "Sau 10 phút bạn mới được phép thao tác tiếp!";
        } else {
            $new_feedback = array(
                "_id" => strval(strtotime('now')),
                "content" => $content,
                "atid" => $atid,
                "type" => $type,
                "datecreate" => strtotime('now'),
                "usersendfeedback" => $uinfo['_id'],
            );
            Feedback::insertDocument($new_feedback);
            $dtr['status'] = 200;
            $dtr['msg'] = "Cám ơn bạn đã quan tâm và sử dụng nhạc tại DJ Pro. Mọi ý kiến đóng góp của bạn sẽ được BQT Dj Pro tiếp nhận và giải quyết trong thời gian sớm nhất.";
            $this->cookies->set($cookie_key, true, time() + (60 * 10))->send(); // set cookie 10 minutus
        }
        Helper::jsonResponse($dtr);
    }

    public function checkusernameAction()
    {
        $username = $_GET['username'];
        if (preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $username) == 1) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Không được phép sử dụng kí tự đặc biệt!';
        } else if (strlen($username) < 5) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Username phải từ 5 ký tự trở lên!';
        } else if (strlen($username) > 60) {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Username không được lớn hơn 60 kí tự!';
        } else {
            $o = Users::findFirst(array('conditions' => array('usernamelowercase' => strtolower($username))));
            if ($o) {
                $dtr['status'] = 300;
                $dtr['msg'] = 'Tài khoản này đã tồn tại!';
            } else {
                $dtr['status'] = 200;
                $dtr['msg'] = 'Successfuly';
            }
        }
        Helper::jsonResponse($dtr);
    }

    public function checkemailAction()
    {
        $email = $_GET['email'];
        $o = Users::findFirst(array('conditions' => array('emaillowercase' => strtolower($email))));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($o) {
                $dtr['status'] = 300;
                $dtr['msg'] = 'Email này đã tồn tại!';
            } else {
                $dtr['status'] = 200;
                $dtr['msg'] = 'Successfuly';
            }
        } else {
            $dtr['status'] = 300;
            $dtr['msg'] = 'Email không hợp lệ!';
        }
        Helper::jsonResponse($dtr);
    }

    public function searchAction()
    {
        $q = Helper::convertToUtf8($_GET['q']);
        $limit = 3;
        $listAudio = Media::getListMedia_BySearch($q, static::$TYPE_MUSIC, $limit);
        $listVideo = Media::getListMedia_BySearch($q, static::$TYPE_VIDEO, $limit);
        $listAlbum = Album::getListAlbum_BySearch($q, static::$TYPE_ALBUM, $limit);//list album
        $listPlaylist = Album::getListAlbum_BySearch($q, static::$TYPE_PLAYLIST, $limit);//list album
        $listTopic = Album::getListAlbum_BySearch($q, static::$TYPE_TOPIC, $limit);//list album
        //List artist
        $listArtist = Artist::findAndReturnArray(array(
            'fields' => array('_id', 'username', 'priavatar', 'link'),
            'condition' => array('$text' => array('$search' => "$q")),
            'limit' => $limit,
        ));
        foreach ($listArtist as &$item) {
            if (empty($item['priavatar']) || !isset($item['priavatar'])) $item['priavatar'] = Helper::getAvatarDefault();
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        $dtr['status'] = 200;
        $dtr['mss'] = "Successfully";
        $dtr['data']['audio'] = count($listAudio) >= 1 ? $listAudio : null;
        $dtr['data']['video'] = count($listVideo) >= 1 ? $listVideo : null;
        $dtr['data']['album'] = count($listAlbum) >= 1 ? $listAlbum : null;
        $dtr['data']['playlist'] = count($listPlaylist) >= 1 ? $listPlaylist : null;
        $dtr['data']['topic'] = count($listTopic) >= 1 ? $listTopic : null;
        $dtr['data']['artist'] = count($listArtist) >= 1 ? $listArtist : null;
        $dtr['q'] = $_GET['q'];
        Helper::jsonResponse($dtr);
    }

    public function addplaylistAction()
    {
        $name = $this->request->get('name');
        $type = isset($_GET['type']) ? $_GET['type'] : "audio";
        $uinfo = $this->session->get('uinfo');
        if (isset($uinfo)) {
            if (empty($name)) {
                $dtr['status'] = 300;
                $dtr['mss'] = "Vui lòng nhập tên playlist";
            } else {
                $newPlaylist = array(
                    '_id' => strval(strtotime('now')),
                    'name' => $name,
                    'type' => 'playlist',
                    'type_play' => $type,
                    'listsong' => [],
                    'status' => 0,
                    'namenonutf' => Helper::convertToUtf8($name),
                    'datecreate' => strtotime('now'),
                    'usercreate' => $uinfo['_id'],
                );
                Album::insertDocument($newPlaylist);
                $dtr['status'] = 200;
                $dtr['mss'] = "Successfully";
                $dtr['data'] = $newPlaylist;
            }
        } else {
            $dtr['status'] = 300;
            $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
        }
        Helper::jsonResponse($dtr);
    }

    public function getallplaylistAction()
    {
        $uinfo = $this->session->get('uinfo');
        $data = Album::findAndReturnArray(array(
            'condition' => array('usercreate' => $uinfo['_id'], 'type' => static::$TYPE_PLAYLIST),
        ));
        $dtr['status'] = 200;
        $dtr['mss'] = "Successfully";
        $dtr['data'] = $data;
        Helper::jsonResponse($dtr);
    }

    public function addsoongtoplaylistAction()
    {
        $pllid = $_GET['pllid'];
        $atid = $_GET['atid'];
        $type = $_GET['type'];
        $o = Album::findFirst(
            array(
                'conditions' => array('_id' => $pllid),
                'fields' => array('_id', 'name', 'listsong')
            )
        );
        $album = Album::findFirst(
            array(
                'conditions' => array('_id' => $atid),
                'fields' => array('_id', 'name', 'listsong', 'type')
            )
        );

        $collectionMusicType = array(static::$TYPE_ALBUM, static::$TYPE_PLAYLIST, static::$TYPE_TOPIC);

        if ($album && in_array($album->type, $collectionMusicType)) { // if atid is album
            $listsong_album = $album->listsong; // list soong of album
            $listsong_playlist = $o->listsong; // list soong of playlist current
            $listsong = array_values(array_unique(array_merge($listsong_album, $listsong_playlist))); // remove element duplicate in array
            $data = Album::updateDocument(array('_id' => $pllid), array('$set' => array('listsong' => $listsong)));
            if ($data) {
                $dtr['status'] = 200;
                $dtr['mss'] = "Successfully";
            } else {
                $dtr['status'] = 300;
                $dtr['mss'] = "Failed";
            }
        } else {
            if (in_array($atid, $o->listsong)) {
                $dtr['status'] = 300;
                $dtr['mss'] = "Bài hát này đã tồn tại trong playlist!";
            } else {
                $data = Album::updateDocument(array('_id' => $pllid), array('$push' => array('listsong' => $atid)));
                if ($data) {
                    $dtr['status'] = 200;
                    $dtr['mss'] = "Successfully";
                } else {
                    $dtr['status'] = 300;
                    $dtr['mss'] = "Failed";
                }
            }

        }

        Helper::jsonResponse($dtr);
    }

    public function getlistartistAction()
    {
        $keyword = Helper::convertToUtf8($this->request->get('q'));
        $type = $this->request->get('type');
//        if (!strlen($type))
//            $type = "audio";

        $query = array(
            '$text' => array('$search' => "\"$keyword\""),
//            'type' => array(
//                '$in' => array("dj")
//            )
        );
        $limit = 20;
        $selectFields = array("username", "_id", "priavatar", "datecreate", "type", "namenonutf");
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields,
            "limit" => $limit
        );
        ## bind Data
        $listnewss = Artist::findAndReturnArray($criteria);
        foreach ($listnewss as $key => $item) {
            $listnewss[$key]['id'] = $listnewss[$key]['_id'];
            $listnewss[$key]['name'] = $item['username'];
            $listnewss[$key]['datecreate'] = date("d-m-Y", $listnewss[$key]['datecreate']);
        }
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        $dtr['items'] = $listnewss;
        Helper::jsonResponse($dtr);
    }

    public function updatestatusonlineAction()
    {

        $uinfo = $this->session->get('uinfo');
        if (isset($uinfo['_id'])) Users::updateDocument(array('_id' => $uinfo['_id']), array('$set' => array('isonline' => 0)));
        $this->session->destroy();
    }

    public function likearticleAction()
    {
        $id = $_GET['atid'];
        $checklike = intval($_GET['checklike']);
        $type = $_GET['type'];
        $uinfo = $this->session->get('uinfo');
        //set time like media
        $cookie_name = $id . '_' . $uinfo['_id'] . '_like';
        $cookie_value = true;
        //add log
        $newlog = array(
            '_id' => strval(strtotime('now')),
            'userid' => $uinfo['_id'],
            'atid' => $id,
            'datecreate' => strtotime('now'),
            'article_type' => $type,
            'type' => static::$OPTION_TYPE_LIKE,
        );
        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == true) {
            $dtr['status'] = 300;
            $dtr['mss'] = "Sau 10 phút bạn mới được phép thao tác tiếp";
        } else {
            setcookie($cookie_name, $cookie_value, time() + (60 * 10), "/"); // set expire cookie 10 minutes
            if ($uinfo['_id']) {
                if ($checklike == 0) {
                    if ($type == static::$TYPE_ALBUM || $type == static::$TYPE_PLAYLIST || $type == static::$TYPE_TOPIC) {
                        $o = Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('like' => 1)));
                        Notify::insertDocument($newlog);
                    } else {
                        $o = Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('like' => 1)));
                        Notify::insertDocument($newlog);
                    }

                } else {
                    if ($type == static::$TYPE_ALBUM || $type == static::$TYPE_PLAYLIST || $type == static::$TYPE_TOPIC) {
                        $o = Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('like' => -1)));
                        Notify::deleteDocument(array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_LIKE));
                    } else {
                        $o = Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('like' => -1)));
                        Notify::deleteDocument(array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_LIKE));
                    }

                }
                $dtr['status'] = 200;
                $dtr['boutlike'] = ($checklike == 0) ? $o['like'] + 1 : $o['like'] - 1;
                $dtr['mss'] = "Success";
            } else {
                $dtr['status'] = 300;
                $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
            }
        }
        Helper::jsonResponse($dtr);
    }

    public function likecommentAction()
    {
        $id = $_GET['atid'];
        $idcomment = $_GET['idcm'];
        $checklike = intval($_GET['checklike']);
        $type = $_GET['type'];
        $uinfo = $this->session->get('uinfo');

        //set time like comment
        $cookie_name = $id . '_' . $uinfo['_id'] . $idcomment . '_likecomment';
        $cookie_value = true;

        $newlog = array(
            '_id' => strval(strtotime('now')),
            'userid' => $uinfo['_id'],
            'atid' => $id,
            'idcomment' => $idcomment,
            'datecreate' => strtotime('now'),
            'article_type' => $type,
            'type' => static::$OPTION_TYPE_LIKE_COMMENT,
        );

        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == true) {
            $dtr['status'] = 300;
            $dtr['mss'] = "Sau 24h bạn mới được phép thao tác tiếp";
        } else {
            setcookie($cookie_name, $cookie_value, time() + (60 * 2), "/"); // 86400 = 1 day
            if ($uinfo['_id']) {
                if ($checklike == 0) {
                    $o = Comment::getCollectionInstance()->findAndModify(array('_id' => $idcomment), array('$inc' => array('like' => 1)));
                    Notify::insertDocument($newlog);
                } else {
                    $o = Comment::getCollectionInstance()->findAndModify(array('_id' => $idcomment), array('$inc' => array('like' => -1)));
                    Notify::deleteDocument(array('idcomment' => $idcomment));
                }
                $dtr['status'] = 200;
                $dtr['like'] = ($checklike == 0) ? $o['like'] + 1 : $o['like'] - 1;
                $dtr['mss'] = "Success";
            } else {
                $dtr['status'] = 300;
                $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
            }
        }


        Helper::jsonResponse($dtr);
    }

    public function dislikearticleAction()
    {
        $id = $_GET['atid'];
        $checklike = intval($_GET['checklike']);
        $type = $_GET['type'];
        $uinfo = $this->session->get('uinfo');
        //set time like media
        $cookie_name = $id . '_' . $uinfo['_id'] . '_dislike';
        $cookie_value = true;

        $newlog = array(
            '_id' => strval(strtotime('now')),
            'userid' => $uinfo['_id'],
            'atid' => $id,
            'datecreate' => strtotime('now'),
            'article_type' => $type,
            'type' => static::$OPTION_TYPE_DISLIKE,
        );
        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == true) {
            $dtr['status'] = 300;
            $dtr['mss'] = "Sau 10 phút bạn mới được phép thao tác tiếp";
        } else {
            setcookie($cookie_name, $cookie_value, time() + (60 * 10), "/"); // set expire cookie 10 minutes
            if ($uinfo['_id']) {
                if ($checklike == 0) {
                    if ($type == static::$TYPE_ALBUM || $type == static::$TYPE_PLAYLIST || $type == static::$TYPE_TOPIC) {
                        $o = Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('dislike' => 1)));
                        Notify::insertDocument($newlog);
                    } else {
                        $o = Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('dislike' => 1)));
                        Notify::insertDocument($newlog);
                    }
                } else {
                    if ($type == static::$TYPE_ALBUM || $type == static::$TYPE_PLAYLIST || $type == static::$TYPE_TOPIC) {
                        $o = Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('like' => -1)));
                        Notify::deleteDocument(array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_LIKE));
                    } else {
                        $o = Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('dislike' => -1)));
                        Notify::deleteDocument(array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_DISLIKE));
                    }
                }
                $dtr['status'] = 200;
                $dtr['boutdislike'] = ($checklike == 0) ? $o['dislike'] + 1 : $o['dislike'] - 1;
                $dtr['mss'] = "Success!";
            } else {
                $dtr['status'] = 300;
                $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
            }
        }
        Helper::jsonResponse($dtr);
    }

    public
    function nominationsAction()
    {
        $uinfo = $this->session->get('uinfo');
        $id = $_POST['atid'];
        $type = $_POST['type'];
        if ($uinfo['_id']) {
            $o = Notify::findFirst(array(
                "conditions" => array(
                    'userid' => $uinfo['_id'],
                    'atid' => $id,
                    'type' => static::$OPTION_TYPE_NOMINATIONS
                ),
            ));
            if ($o) {
                $dtr['status'] = 300;
                $dtr['mss'] = "Bạn đã đề cử rồi,ko thể đề cử đc nữa!";
            } else {
                if ($type == static::$TYPE_ALBUM || $type == static::$TYPE_PLAYLIST || $type == static::$TYPE_TOPIC)
                    Album::updateDocument(array('_id' => $id), array('$inc' => array('nominations' => 1)));
                else Media::updateDocument(array('_id' => $id), array('$inc' => array('nominations' => 1)));
                $newlog = array(
                    '_id' => strval(strtotime('now')),
                    'userid' => $uinfo['_id'],
                    'atid' => $id,
                    'datecreate' => strtotime('now'),
                    'article_type' => $type,
                    'type' => static::$OPTION_TYPE_NOMINATIONS,
                );
                Notify::insertDocument($newlog);
                RankingArticle::increaseActionNumber("nomination", $id, $type);
                $dtr['status'] = 200;
                $dtr['mss'] = "Insert success";
            }

        } else {
            $dtr['status'] = 300;
            $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
        }
        Helper::jsonResponse($dtr);
    }

    public
    function sendcommentAction()
    {
        $uinfo = $this->session->get('uinfo');
        $content = strip_tags(htmlspecialchars($this->request->get('content')));
        $type = $this->request->get('type');
        $atid = $_POST['atid'];
        if (strlen($content) >= 3) {
            $newcm = array(
                '_id' => strval(strtotime('now')),
                'user_id' => $uinfo['_id'],
                'parent_id' => "0",
                'content' => $content,
                'atid' => $atid,
                'type' => $type,
                'datecreate' => strtotime('now'),
            );
            Comment::insertDocument($newcm);
            $o = Users::getUserById($uinfo['_id']);
            $newcm['content'] = Helper::CheckStringExpletives($content);
            $dtr['status'] = 200;
            $dtr['data'] = $newcm;
            $dtr['link'] = $o->link;
            $dtr['priavatar'] = $o->priavatar;
            $dtr['mss'] = "Successfully";
        } else {
            $dtr['status'] = 300;
            $dtr['mss'] = "Vui lòng comment ít nhất 3 kí tự trở lên!";
        }

        Helper::jsonResponse($dtr);
    }

    public function replycommentAction()
    {
        $uinfo = $this->session->get('uinfo');
        $parentid = $this->request->get('parentid');
        $uid = $this->request->get('uid');
        $content = htmlspecialchars($this->request->get('content'));
        $atid = $this->request->get('atid');
        $type = $this->request->get('type');
        if (isset($uid)) {
            $userobj = Users::getUserById($uid);
        }
        if (strlen($content) >= 3) {
            if ($uinfo['_id']) {
                $newcm = array(
                    '_id' => strval(strtotime('now')),
                    'user_id' => $uinfo['_id'],
                    'parent_id' => $parentid,
                    'parent_name' => isset($userobj) ? $userobj->username : '',
                    'content' => $content,
                    'atid' => $atid,
                    'type' => $type,
                    'datecreate' => strtotime('now'),
                );
                Comment::insertDocument($newcm);
                $o = Users::getUserById($uinfo['_id']);
                $newcm['content'] = Helper::CheckStringExpletives($content);
                $dtr['status'] = 200;
                $dtr['data'] = $newcm;
                $dtr['link'] = $o->link;
                $dtr['priavatar'] = $o->priavatar;
                $dtr['mss'] = "Successfully";

            } else {
                $dtr['status'] = 300;
                $dtr['mss'] = "Vui lòng đăng nhập để sử dụng tính năng này!";
            }
        } else {
            $dtr['status'] = 300;
            $dtr['mss'] = "Vui lòng comment ít nhất 3 kí tự trở lên!";
        }

        Helper::jsonResponse($dtr);
    }

    public
    function getcommentAction()
    {
        $atid = $_POST['atid'];
        $data = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $atid),
        ));
        foreach ($data as &$item) {
            $uid = $item['user_id'];
            $o = Users::findFirst(array('conditions' => array('_id' => $uid)));
            $item['username'] = $o->username;
            unset($uid);
        }
        $dtr['status'] = 200;
        $dtr['data'] = $data;
        $dtr['mss'] = "Successfully";
        Helper::jsonResponse($dtr);
    }

    public
    function loadreplycommentAction()
    {
        $uinfo = $this->session->get('uinfo');
        $atid = $_GET['atid'];
        $parentid = $_GET['parentid'];
        $p = $_GET['p'];
        if ($p <= 0) $p = 1;
        $limit = 4;
        $skip = ($p - 1) * $limit;
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('parent_id' => $parentid),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => 1),
        ));
        foreach ($listcomment as &$item) {
            $id = $item['_id'];
            $uid_child = $item['user_id'];
            $o = Users::getUserById($uid_child);// get user by userid
            $item['priavatar'] = $o->priavatar;
            $item['link'] = $o->link;
            $item['is_comment_of_my'] = ($uid_child == $uinfo['_id']) ? 1 : 0;
            $item['username'] = Users::getUserInfo($item['user_id']);
            $checklike = Notify::getNotifyByIdCM($id, $uinfo['_id']);//check like comment
            $item['checklike'] = isset($checklike->_id) ? 1 : 0;
        }
        $dtr['data'] = $listcomment;
        $dtr['stt'] = 200;
        $dtr['msg'] = 'Successfuly';
        Helper::jsonResponse($dtr);
    }

    public function loadcommentAction()
    {
        $uinfo = $this->session->get('uinfo');
        $atid = $_GET['atid'];
        $p = $_GET['p'];
        if ($p <= 0) $p = 1;
        $limit = 4;
        $skip = ($p - 1) * $limit;
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $atid, 'parent_id' => "0"),
            'limit' => $limit,
            'skip' => $skip,
            'sort' => array('datecreate' => -1),
        ));
        foreach ($listcomment as &$item) {
            $id = $item['_id'];
            $uid = $item['user_id'];
            $o = Users::getUserById($uid);// get user by userid
            $item['priavatar'] = $o->priavatar;
            $item['link'] = $o->link;
            $item['is_comment_of_my'] = ($uid == $uinfo['_id']) ? 1 : 0;
            $item['username'] = Users::getUserInfo($uid);//get username
            $checklike = Notify::getNotifyByIdCM($id, $uinfo['_id']);//check like comment
            $item['checklike'] = isset($checklike->_id) ? 1 : 0;
            $listcomment_children = Comment::getListCommentChildren($id, $uinfo);
            if ($listcomment_children) $item['comment_children'] = $listcomment_children;
            $count = count(Comment::findAndReturnArray(array('condition' => array('parent_id' => $id))));
            $item['content'] = Helper::CheckStringExpletives($item['content']);
            $item['total_page_repcomment'] = ceil($count / 4);
            $item['total_repcomment'] = $count;
            unset($uid, $id, $uid_child);
        }
        $dtr['data'] = $listcomment;
        $dtr['stt'] = 200;
        $dtr['msg'] = 'Successfuly';
        Helper::jsonResponse($dtr);
    }

    public function updatetimeactivityAction()
    {
        $uinfo = $this->session->get('uinfo');
        $timecurrent = intval(strtotime('now'));
        if ($uinfo['_id']) {
            Users::updateDocument(array('_id' => $uinfo['_id']), array('$set' => array('timeactivity' => $timecurrent)), array('upsert' => true));
            $dtr['status'] = 200;
            $dtr['msg'] = 'Sucessfuny!';
        } else {
            $dtr['status'] = 202;
            $dtr['msg'] = 'User no login!';
        }
    }
}
