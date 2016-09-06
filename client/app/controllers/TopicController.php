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
use DjClient\Models\Settings;
use DjClient\Models\Topic;
use DjClient\Models\Users;

class TopicController extends ControllerBase
{
    public static $TYPE_SELECTIVE_TOPIC = 'selective_topic';

    public function indexAction()
    {
        // echo 1;die;
        $limit = 6;
        ## banner header
        $cursor = Album::findFirst(array(
            'conditions' => array('isspecial' => 1, 'status' => static::$STATUS_ON),
            'sort' => array('sort' => 1),
        ));
        $cursor->link = Makelink::link_view_article_playlist_music($cursor->name, $cursor->_id);
        $artistid = $cursor->artist;
        $listArtist = array();
        if (isset($artistid) && !empty($artistid)) {
            $listArtist = Artist::getArtistByID($artistid);
            $cursor->artist = $listArtist;
        }
        $listcategory = Category::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_TOPIC, 'is_topic' => true, 'status' => static::$STATUS_ON),
            'sort' => array('sort' => 1),
            'limit' => $limit
        ));
        foreach ($listcategory as $key => $item) {
            $categoryid = $item['_id'];
            $listopic = Album::getListAlbumByCategory($categoryid, 5, 3);
            $listcategory[$key]['listtopic'] = $listopic;
            unset($listopic);
        }
        $count = Category::findAndReturnArray(array('condition' => array('type' => self::$TYPE_TOPIC, 'status' => static::$STATUS_ON)));
        ##list topic new
        $listTopic_New = Album::ListAlbumByMultiConditions(self::$TYPE_TOPIC, 4, 1);
        ##list topic selective
        $listIdtopic = Settings::getElementByKey(self::$TYPE_SELECTIVE_TOPIC);
        $listTopicSelectvie = Album::ListAlbumByMultiConditions(self::$TYPE_SELECTIVE_TOPIC, 4, 1, $listIdtopic);
        $listTopicSelectvie = Helper::resortarray($listTopicSelectvie, $listIdtopic, "_id");
        ##breadcrumb
        $this->breadCrumbs->addItem(array(), static::$TYPE_TOPIC);
        $this->view->listtopic = $listcategory;
        $this->view->listTopic_New = $listTopic_New;
        $this->view->listTopicSelectvie = $listTopicSelectvie;
        $this->view->topic_special = $cursor;
        $this->view->header = Helper::setHeader('Chủ đề', '', '');
    }

    public function newAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $listTopic = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_TOPIC, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listTopic as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_TOPIC, 'status' => static::$STATUS_ON),
        ));
        $this->breadCrumbs->addItem(array("name" =>"Chủ đề mới nhất","link" => "/chu-de-moi.html"), static::$TYPE_TOPIC);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listtopic = $data;
        $this->view->header = Helper::setHeader('Chủ đề mới nhất', '', '');
    }

    public function selectiveAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 8;
        $skip = ($p - 1) * $limit;
        $listIdtopic = Settings::getElementByKey(self::$TYPE_SELECTIVE_TOPIC);
        $list_SelectiveTopic = Album::findAndReturnArray(array(
            'fields' => array('name', '_id', 'view', 'usercreate', 'priavatar', 'artist', 'listartist', 'sort'),
            'condition' => array('_id' => array('$in' => $listIdtopic), 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
        ));
        $list_SelectiveTopic = Helper::resortarray($list_SelectiveTopic, $listIdtopic, "_id");
        foreach ($list_SelectiveTopic as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdtopic), 'status' => static::$STATUS_ON),
        ));
        $this->breadCrumbs->addItem(array("name" =>"Chủ đề chọn lọc","link" => "/chu-de-chon-loc.html"), static::$TYPE_TOPIC);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listTopic_selective = $data;
        $this->view->header = Helper::setHeader('Chủ đề chọn lọc', '', '');
    }

    public function highlightsAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $listcategory = Category::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_TOPIC, 'is_topic' => true, 'status' => static::$STATUS_ON),
            'sort' => array('sort' => 1),
            'skip' => $skip,
            'limit' => $limit,
        ));
        foreach ($listcategory as $key => $item) {
            $categoryid = $item['_id'];
            $listopic = Album::getListAlbumByCategory($categoryid, 5, 3);
            $listcategory[$key]['listtopic'] = $listopic;
            unset($listopic);
        }
        $count = Category::findAndReturnArray(array('condition' => array('type' => self::$TYPE_TOPIC, 'is_topic' => true, 'status' => static::$STATUS_ON)));
        $this->breadCrumbs->addItem(array("name" =>"Chủ đề nổi bật","link" => "/chu-de-noi-bat.html"), static::$TYPE_TOPIC);
        $this->view->listtopic = $listcategory;
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->header = Helper::setHeader('Chủ đề nổi bật', '', '');
    }

}

