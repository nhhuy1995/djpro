<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Settings;
use DjClient\Models\Tags;
use DjClient\Models\Users;
use DjClient\Services\RankingArticle;


class VideoController extends ControllerBase
{
    public static $TYPE_SELECTIVE_VIDEO = 'selective_video';

    public function indexAction()
    {
        $limit = 8;
        $listVideo = Media::ListMusicByMultiConditions(self::$TYPE_VIDEO, $limit, 1);
        //list video selective
        $listIdVideo = Settings::getElementByKey(self::$TYPE_SELECTIVE_VIDEO);
        $listVideoSelectvie = Helper::resortarray(Media::ListMusicByMultiConditions(self::$TYPE_SELECTIVE_VIDEO, $limit, 1, $listIdVideo), $listIdVideo, "_id");
        $this->view->listvideo = $listVideo;
        $this->view->listvideoselective = $listVideoSelectvie;
        $this->view->title = 'Video';
    }

    public function newAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 15;
        $skip = ($p - 1) * $limit;
        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_VIDEO, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listVideo as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_VIDEO, 'status' => static::$STATUS_ON),
        ));

        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listVideo = $data;
        $this->view->title = 'Video mới';
    }

    public function selectiveAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listIdVideo = Settings::getElementByKey(self::$TYPE_SELECTIVE_VIDEO);
        $list_SelectiveVideo = Media::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdVideo), 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'skip' => $skip,
            'limit' => $limit,
        ));
        $list_SelectiveVideo = Helper::resortarray($list_SelectiveVideo, $listIdVideo, "_id");
        foreach ($list_SelectiveVideo as $item) {
            $artistid = $item['artist'];
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = $makelink = Makelink::link_view_article_video($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdVideo), 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listVideo_selective = $data;
        $this->view->title = 'Video chọn lọc';

        unset($data);
    }

    public function viewAction()
    {
        $id = $this->dispatcher->getParam('atId');
        $uinfo = $this->session->get('uinfo');
        $o = (object)Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        $o->link = Makelink::link_view_article_video($o->name, $o->_id);
        $this->view->listVideo = Media::ListMusicByMultiConditions(self::$TYPE_VIDEO, 5, 1);; //Video other
        ##List Video by view
        $ranking = new RankingController();
        $this->view->listvideobyview = $ranking->getMediaConditions('Media', 'video', 'month', 10);//maybe you want view
        $categoryId = $o->category;
        $artistid = $o->artist;
        $tagID = $o->tags;
        $listCategory = array();
        $listtags = array();
        if (!empty($artistid) && isset($artistid)) $listArtist = Helper::resortarray(Artist::getArtistByID($artistid), $artistid, '_id');
        if (!empty($tagID) && isset($tagID)) $listtags = Helper::resortarray(Tags::getListTagsByID(self::$TYPE_VIDEO, $tagID), $tagID, '_id');
        if ($categoryId) $listCategory = Category::getCategoryByID(self::$TYPE_VIDEO, $categoryId);
        //check đề cử,like,dislike
        if (isset($uinfo['_id'])) {
            $o_nominations = Notify::findFirst(array("conditions" => array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_NOMINATIONS),));
            $o_like = Notify::findFirst(array("conditions" => array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_LIKE),));
            $o_dislike = Notify::findFirst(array("conditions" => array('userid' => $uinfo['_id'], 'atid' => $id, 'type' => static::$OPTION_TYPE_DISLIKE),));
        }
        //get list comment by article
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $id, 'parent_id' => "0"),
        ));
        $total_page_comment = ceil(count($listcomment) / 10);
        if (isset($o->usercreate) && !empty($o->usercreate)) { // get info of user create
            $usercreateInfo = Users::getUserById($o->usercreate);
            $o->usercreate = $usercreateInfo->username;
            $o->usercreatelink = $usercreateInfo->link;
            $o->usercreate_namerole = $usercreateInfo->namerole;
            $o->is_role = $usercreateInfo->is_role;
        }
        $o->view = isset($o->view) ? Helper::Numberformat($o->view) : 0;
        $o->like = isset($o->like) ? Helper::Numberformat($o->like) : 0;
        $o->dislike = isset($o->dislike) ? Helper::Numberformat($o->dislike) : 0;
        ##total comment
        $total_comment = Comment::count(array(
            'conditions' => array('atid' => $id,'type' => static::$TYPE_VIDEO),
        ));
        //check link video
        $checklink = Helper::contains('https://www.youtube', $o->mediaurl);
        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);

        $this->view->setVars(array(
            'checklink' => $checklink,
            'listartist' => $listArtist,
            'listtags' => $listtags,
            'title' => $o->name,
            'listCategory' => $listCategory,
            'total_page_comment' => $total_page_comment,
            'object' => $o,
            'total_comment' => $total_comment,
            'check_nominations' => $o_nominations,
            'check_like' => $o_like,
            'check_dislike' => $o_dislike,
            'currentLink' => DOMAIN . Helper::cpagerparm("")
        ));
    }

    public function categoryAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $id = $this->dispatcher->getParam('catId');
        $o = Category::findById($id);
        $this->viewComponent->createBreadcrumb($id);

        $listVideo = Media::findAndReturnArray(array(
            'condition' => array('category' => $id, '_id' => array('$ne' => $id), 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listVideo as $item) {
            $artistid = $item['artist'];
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
            $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            if (!empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('category' => $id, 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listVideo = $data;
        $this->view->title = $o->name;
        $this->view->object = $o;
        $this->view->link = Makelink::link_view_category_video($o->name, $o->getId());
    }

    public function testAction()
    {

    }
}

