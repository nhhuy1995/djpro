<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Category;
use DjClient\Models\Media;
use DjClient\Models\Settings;
use DjClient\Models\Users;
use DjClient\Services\ViewComponent as ViewComponent;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public static $TYPE_CATEGORY_FOOTER = 'menu_footer';
    protected static $TYPE_CATEGORY_HOME = 'main_menu_index';
    public static $STATUS_ON = 1;
    public static $STATUS_HIDDEN = 3;
    public static $STATUS_DELETE = 2;
    protected static $TYPE_VIDEO = 'video';
    protected static $TYPE_MUSIC = 'audio';
    protected static $TYPE_ALBUM = 'album';
    protected static $TYPE_TOPIC = 'topic';
    protected static $TYPE_ARTIST = 'artist';
    public static $TYPE_NEWS = 'news';
    public static $TYPE_IMAGES = 'images';
    protected static $TYPE_PLAYLIST = 'playlist';
    protected static $OPTION_TYPE_LIKE_COMMENT = 'likecomment';
    protected static $OPTION_TYPE_LIKE = 'like';
    protected static $OPTION_TYPE_NEWS = 'news';
    protected static $OPTION_TYPE_DISLIKE = 'dislike';
    protected static $OPTION_TYPE_NOMINATIONS = 'nominations';

    /**
     * @var ViewComponent
     */
    protected $viewComponent;

    /** @var  \Redis */
    protected $redisConnect;

    protected function initialize()
    {
        //list category
        $listCategory = Settings::getElementByKey(self::$TYPE_CATEGORY_HOME);
        $listcategory_header = array();
        foreach ($listCategory as $item) {
            if (isset($item['child'])) $count = count($item['child']);
            $item['countchildcolumn'] = $count <= 0 ? 0 : ceil($count / 6);
            $listcategory_header[] = $item;
        }
        ##settimeout session
        $session_userinfo = $this->session->get('uinfo');
        if (isset($session_userinfo)) {
            $ob = Users::findById($session_userinfo['_id']);
            $checktime_online = ceil((strtotime(date('H:i:s')) - strtotime(date('H:i:s', $ob->timeactivity))) / 60);
            if ($checktime_online >= 10) { //nếu 10p user ko thao tác thì sẽ hủy session
//                $this->session->destroy();
//                $this->response->redirect('/');
            }
        }
        $this->view->setVars(array(
            'listcategory_header' => $listcategory_header,
            'listCategory_footer' => Settings::getElementByKey(self::$TYPE_CATEGORY_FOOTER),//Menu footer,
            'listcategory_form_uploadmusic' => Category::findAndReturnArray(array('condition' => array('type' => array('$in' => array('audio', 'video')),'status' => static::$STATUS_ON),'sort' => array('sort' => 1),)),
            'listMusic' => Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, 10, 1),## list music maybe you want to hear
            'listcategory' => Category::findAndReturnArray(array('condition' => array('status' => static::$STATUS_ON))),//list category for form upload music
        ));

        $this->viewComponent = new ViewComponent();
        $this->view->DOMAIN = DOMAIN;
        $this->view->session = $session_userinfo;
        $this->redisConnect = $this->getDI()->getShared('redisConnect');
        $this->view->session = $this->session->get('uinfo');
        ##link login fb
        $appid = $this->config->facebook->appid;
        $urlfb = "https://www.facebook.com/dialog/oauth?client_id=$appid&redirect_uri=http://dj.pro.vn/user/callbackfb";
        $this->view->urllogin_fb = $urlfb;
        ##link login google
        $this->view->urllogin_google = Helper::genlinkConfirmGoogle();
//        $this->redisConnect = $this->getDI()->getShared('redisConnect');

    }
}
