<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Topic;
use DjClient\Models\Users;

class SelectivearticleController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function topicAction()
    {
        $uinfo = $this->session->get('uinfo');
        $id = $this->dispatcher->getParam('atId');
        $o = (object)Topic::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        $categoryId = $o->category;
        $song = $o->listsong;
        $listCategory = array();
        $listSong = array();
        $data = array();
        if ($categoryId) {
            $listCategory = Category::findAndReturnArray(array(
                'fields' => array('_id', 'name'),
                'condition' => array('_id' => array('$in' => $categoryId)),
            ));

        }
        if ($song) {
            $listSong = Media::findAndReturnArray(array(
                'condition' => array('_id' => array('$in' => $song), 'status' => array('$ne' => self::$STATUS_HIDDEN)),
            ));
            foreach ($listSong as $item) {
                //check like
                $checklike = Notify::getNotifyByType($uinfo['_id'], $item['_id'], static::$OPTION_TYPE_LIKE);
                $item['checklike'] = isset($checklike->_id) ? 1 : 0;
                //check nominations
                $o_nominations = Notify::getNotifyByType($uinfo['_id'], $item['_id'], static::$OPTION_TYPE_NOMINATIONS);
                $item['nominations'] = isset($o_nominations->_id) ? 1 : 0;
                $item['url'] = DOMAIN . $item['mediaurl'];
                $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
                $item['usercreate'] = Users::getUserInfo($item['usercreate']);
                $data[] = $item;
            }
        }
        //get list comment by article
        $listcomment = Comment::findAndReturnArray(array(
                'condition' => array('atid' => $id, 'parent_id' => "0"),
        ));
        $total_page_comment = ceil(count($listcomment) / 10);
        $this->view->setVars(array(
            'currentLink' => DOMAIN . Helper::cpagerparm(""),
                'listSong' => $data,
                'listcategory' => $listCategory,
                'total_page_comment' => $total_page_comment,
                'total_comment' => count($listcomment),
                'title' => $o->name,
                'usercreate' => Users::getUserInfo($o->usercreate),
                'object' => $o,
        ));

        //Album
        $listAlbum = Album::findAndReturnArray(array(
            'fields' => array('name', '_id', 'priavatar', 'usercreate'),
            'condition' => array('type' => self::$TYPE_ALBUM, 'status' => array('$ne' => self::$STATUS_HIDDEN)),
            'sort' => array('datecreate' => -1),
            'limit' => 5,
        ));

        foreach ($listAlbum as &$item) {
            $item['usercreate'] = Users::getUserInfo($item['usercreate']);
        }
        $this->view->listalbum = $listAlbum;
    }



}

