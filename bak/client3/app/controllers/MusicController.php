<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\BaseCollection;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Settings;
use DjClient\Models\Tags;
use DjClient\Models\Users;
use DjClient\Services\RankingArticle;

class MusicController extends ControllerBase
{
    public static $TYPE_SELECTIVE_AUDIO = "selective_audio";
    public static $Quality_64K = 64;
    public static $Quality_128K = 128;
    public static $Quality_320K = 320;

    public function indexAction()
    {
        $limit = 10;
        $listMusic = Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, $limit, 1);
        //audio selective
        $listIdAudio = Settings::getElementByKey(self::$TYPE_SELECTIVE_AUDIO);
        $listAudioSelectvie = Helper::resortarray(Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, $limit, 1, $listIdAudio), $listIdAudio, "_id");
        $this->view->listMusic = $listMusic;
        $this->view->listAudioSelectvie = $listAudioSelectvie;
        $this->view->header = Helper::setHeader('Bài hát', '', '');
        unset($data);


    }

    public function newAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $listMusic = Media::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMusic as &$item) {
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
        ));

        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listMusic = $data;
        $this->view->header = Helper::setHeader('Bài hát mới', '', '');
        unset($data);


    }

    public function viewAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $uinfo = $this->session->get('uinfo');
        $quality = intval($this->request->get('qlt'));
        $o = (object)Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        if (!isset($o->_id)) return $this->response->redirect('/error.html');
        $o->link = $this->config->application->site . Makelink::link_view_article_music($o->name, $o->_id);
        $categoryId = $o->category;
        $listCategory = array();
        if ($categoryId) {
            $listCategory = Category::getCategoryByID(self::$TYPE_MUSIC, $categoryId);
        }
        ##get artist
        $artistId = $o->artist;
        $listArtist = array();
        if (isset($artistId) && !empty($artistId))
            $listArtist = Helper::resortarray(Artist::getArtistByID($artistId), $artistId, '_id');

        unset($artistId);
        $o->view = isset($o->view) ? Helper::Numberformat($o->view) : 0;
        $o->like = isset($o->like) ? Helper::Numberformat($o->like) : 0;
        $o->dislike = isset($o->dislike) ? Helper::Numberformat($o->dislike) : 0;
        $o->download = isset($o->download) ? Helper::Numberformat($o->download) : 0;
        $o->priavatar = Helper::checkAvatar($o->usercreate, $o->priavatar);
        if (isset($o->usercreate) && !empty($o->usercreate)) { // get info of user create
            $usercreateInfo = Users::getUserById($o->usercreate);
            $o->usercreate = $usercreateInfo->username;
            $o->usercreatelink = $usercreateInfo->link;
            $o->usercreate_namerole = $usercreateInfo->namerole;
            $o->is_role = $usercreateInfo->is_role;
        }

        $o->link = Makelink::link_view_article_music($o->name, $o->_id);
        if (isset($o->media_link_64k)) $media_url = $o->media_link_64k;
        else $media_url = $o->direct_media_url;
        $o->media_url = $media_url;
        $this->view->setVars(array(
            "object" => $o,
            "listartist" => $listArtist,
            "title" => $o->name,
            "listcategory" => $listCategory,
        ));
        ##list Audio by view
        $ranking = new RankingController();
        $this->view->listmusicbyview = $ranking->getMediaConditions('Media', 'audio', 'month', 5);## list music by view
        $this->view->listalbum = Album::ListAlbumByMultiConditions(self::$TYPE_ALBUM, 5, 1);##Album

        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);
        ##check đề cử,like,dislike
        if (isset($uinfo)) {
            $o_like = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_LIKE);
            $o_dislike = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_DISLIKE);
            $o_nominations = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_NOMINATIONS);
        }
        ##list tags
        $tagsid = $o->tags;
        $listtags = array();
        if ($tagsid) $listtags = Tags::getListTagsByID(self::$TYPE_MUSIC, $tagsid);
        ##get list comment by article
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $id, 'parent_id' => "0"),
        ));
        $total_page_comment = ceil(count($listcomment) / 4);
        $total_comment = Comment::count(array(
            'conditions' => array('atid' => $id),
        ));
        $this->view->setVars(array(
            'check_nominations' => $o_nominations,
            'total_page_comment' => $total_page_comment,
            'total_comment' => $total_comment,
            'listtags' => $listtags,
            'check_like' => $o_like,
            'check_dislike' => $o_dislike,
            'iframe_share_link' => DOMAIN . Makelink::link_view_embed_music($id),
            'currentLink' => str_replace('?', '', DOMAIN . Helper::cpagerparm(""))
        ));
        ##header
        $listArtistName = '';
        if (isset($listArtist) && !empty($listArtist)) {
            foreach ($listArtist as $item) $listArtistName .= $item['username'] . ' ft. ';
            $listArtistName = ' - ' . rtrim($listArtistName, 'ft. ');
            $listArtistNameRePlace = str_replace(' - ', '', $listArtistName);
        }
        $title = $o->name . $listArtistName . ' - Upload bởi ' . $o->usercreate;
        if (empty($o->content) || strip_tags($o->content) == 'No Track!') {
            $namenonUtf = Helper::convertToUtf8($o->name);
            $content = "{$o->name} Mp3, Tải Download BÀI HÁT {$namenonUtf} - $listArtistNameRePlace HAY MỚI NHẤT chất lượng cao 320Kbps";
            $content = str_replace('  ', ' ', $content);
        } else $content = $o->content;
        $listCategoryName = ' ';
        if (isset($listCategory) && !empty($listCategory)) {
            foreach ($listCategory as $item) $listCategoryName .= $item['name'] . ', ';
            $listCategoryName = ' ' . $listCategoryName . ' ';
        }
        if (empty($listArtistNameRePlace)) $listArtistNameRePlace = '';
        else $listArtistNameRePlace = str_replace(' ft.', ', ', $listArtistNameRePlace) . ', ';

        $keyword = "Nghe, Bài hát, Mp3, Download, {$o->name}, {$listArtistNameRePlace}{$o->usercreate},{$listCategoryName}320Kbps";
        $keyword = str_replace('  ', ' ', $keyword);
        $this->view->header = Helper::setHeader($title, strip_tags($content), $o->priavatar, $content, $keyword);
    }

    public function selectiveAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listIdAudio = Settings::getElementByKey(self::$TYPE_SELECTIVE_AUDIO);
        $list_SelectiveAudio = Media::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdAudio), 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'skip' => $skip,
            'limit' => $limit,
        ));
        $list_SelectiveAudio = Helper::resortarray($list_SelectiveAudio, $listIdAudio, "_id");
        foreach ($list_SelectiveAudio as $item) {
            $artistid = $item['artist'];
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = $makelink = Makelink::link_view_article_video($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdAudio), 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listAudio_selective = $data;
        $this->view->header = Helper::setHeader('Bài hát chọn lọc', '', '');
        unset($data);
    }

    public function categoryAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 10;
        $skip = ($p - 1) * $limit;
        $id = $this->dispatcher->getParam('catId');
        $o = Category::findById($id);
        if ($o == false) return $this->response->redirect('/error.html');

        $listMusic = Media::findAndReturnArray(array(
            'condition' => array('category' => $id, 'type' => self::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listMusic as &$item) {
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::count(array(
            'conditions' => array('category' => $id, 'type' => self::$TYPE_MUSIC, 'status' => static::$STATUS_ON),
        ));

        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->listMusic = $data;
        $this->view->header = Helper::setHeader($o->name, '', '');
        $this->view->object = $o;
        $this->view->link = Makelink::link_view_category_music($o->name, $o->getId());

    }
}

