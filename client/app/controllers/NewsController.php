<?php
namespace DjClient\Controller;


use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Tags;
use DjClient\Models\Users;

class NewsController extends ControllerBase
{
    public static $TYPE_NEWS = 'news';

    public function indexAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $listNews = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_NEWS, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listNews as $item) {
            $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_NEWS, 'status' => static::$STATUS_ON),
        ));
        $this->breadCrumbs->addItem(array(), static::$TYPE_NEWS);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listNews = $data;
        $this->view->header = Helper::setHeader('Tin tức', '', '');
    }

    public function categoryAction()
    {
        $catid = $this->dispatcher->getParam('catId');
        $catinfo = Category::findById($catid);
        if (!$catinfo) return $this->response->redirect('/error.html');

        $catinfo->link = Makelink::link_view_category_news($catinfo->name, $catinfo->getId());
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $listNews = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_NEWS, 'category' => $catid, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listNews as $item) {
            $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_NEWS, 'category' => $catid, 'status' => static::$STATUS_ON),
        ));

        $this->breadCrumbs->addItem($catinfo->toArray(), static::$TYPE_NEWS);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listNews = $data;
        $this->view->catinfo = $catinfo;
        $this->view->header = Helper::setHeader($catinfo->name, '', '');
    }

    public function viewAction()
    {
        $uinfo = $this->session->get('uinfo');
        $id = $this->dispatcher->getParam('atId');
        $object = (object)Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        if (!isset($object->_id)) $this->response->redirect('/error.html');
        $object->link = Makelink::link_view_article($object->name, $object->_id);
        if (isset($object->usercreate) && !empty($object->usercreate)) { // get info of user create
            $usercreateInfo = Users::getUserById($object->usercreate);
            $object->usercreate = $usercreateInfo->username;
            $object->usercreatelink = $usercreateInfo->link;
            $object->usercreate_namerole = $usercreateInfo->namerole;
            $object->is_role = $usercreateInfo->is_role;
        }
        $object->view = isset($object->view) ? Helper::Numberformat($object->view) : 0;
        $object->like = isset($object->like) ? Helper::Numberformat($object->like) : 0;
        $object->dislike = isset($object->dislike) ? Helper::Numberformat($object->dislike) : 0;
        $tagid = $object->tags;
        $categoryid = $object->category;

        $listtags = array();
        $listcategory = array(array("name" => "Đang cập nhật", "link" => "javascript:void(0)"));
        if (!empty($tagid) && isset($tagid)) $listtags = Helper::resortarray(Tags::getListTagsByID(self::$TYPE_NEWS, $tagid), $tagid, '_id');
        if (!empty($categoryid) && isset($categoryid)) $listcategory = Category::getCategoryByID($object->type, $categoryid);

        //article relative
        $article_relative = Media::findAndReturnArray(array(
            'condition' => array('_id' => array('$ne' => $id), 'type' => $object->type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'limit' => 6
        ));

        foreach ($article_relative as &$item) $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
        //check like,dislike
        $o_like = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_LIKE);
        $o_dislike = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_LIKE);
        //get list comment by article
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $id, 'parent_id' => "0"),
        ));
        $total_page_comment = ceil(count($listcomment) / 4);
        ##total comment
        $total_comment = Comment::count(array(
            'conditions' => array('atid' => $id),
        ));

        $this->breadCrumbs->addListItems($listcategory, $object->type);
        $this->view->setVars(array(
            'check_like' => $o_like,
            'check_dislike' => $o_dislike,
            'total_page_comment' => $total_page_comment,
            'total_comment' => $total_comment,
            "object" => $object,
            "listtags" => $listtags,
            "listcategory" => $listcategory,
            "articlerelative" => $article_relative,
            "not_link_embed" => true,
            'currentLink' => str_replace('?', '', DOMAIN . Helper::cpagerparm(""))
        ));

        $this->view->header = Helper::setHeader($object->name, $object->description, $object->priavatar);
    }
}

