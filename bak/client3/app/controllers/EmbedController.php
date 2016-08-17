<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Media;
use DjClient\Models\Settings;
use DjClient\Models\Users;
use DjClient\Services\RankingArticle;

class EmbedController extends ControllerBase
{
    public static $TYPE_SELECTIVE_ALBUM = 'selective_album';

    public function musicAction()
    {
        $id = $this->dispatcher->getParam('at_id');
        $quality = intval($this->request->get('qlt'));
        $o = (object)Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        
        if (!isset($o->_id)) 
            $this->response->redirect('/error.html');

        $o->link = Makelink::link_view_article_music($o->name, $o->_id);
        if (isset($o->media_link_320k)) 
            $media_url = $o->media_link_320k;
        else 
            $media_url = $o->direct_media_url;
        $o->media_url = $media_url;

        $this->view->setVars(array(
            "object" => $o,
        ));
        $this->view->header = Helper::setHeader($o->name,$o->description, $o->priavatar);
        $this->view->setMainView('embed');
        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);
    }

    public function collectionAction()
    {
        $id = $this->dispatcher->getParam('cl_id');
        $o = (object)Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        if (!isset($o->_id)) $this->response->redirect('/error.html');
 
        $o->priavatar = Helper::checkAvatar($o->usercreate, $o->priavatar);
        $o->link = Makelink::link_view_article_playlist_music($o->name, $o->_id);
        $listSong = array();
        $data = array();
        $listsongId = array();
        $listsongId = $o->listsong;
        if ($listsongId) {
            $listSong = Media::findAndReturnArray(array(
                'condition' => array('_id' => array('$in' => $listsongId), 'status' => static::$STATUS_ON),
            ));
            foreach ($listSong as $item) {
                $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
                ##check link default
                if (isset($item['media_link_64k'])) $media_url = $item['media_link_64k'];
                else $media_url = $item['media_link_64k'];
                $item["direct_media_url"] = $media_url;
                $data[] = $item;
            }
        }
        
        $this->view->setVars(array(
            'currentLink' => DOMAIN . Helper::cpagerparm(""),
            'listSong' => $data,
            'object' => $o,
        ));
        $this->view->header = Helper::setHeader($o->name,$o->description, $o->priavatar);
        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);
    }

    public function videoAction() 
    {
        $id = $this->dispatcher->getParam('at_id');
        $o = (object)Media::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        if (!isset($o->_id)) $this->response->redirect('/error.html');
        $o->link = Makelink::link_view_article_video($o->name, $o->_id);
        //check link video
        $checklink = Helper::contains('https://www.youtube', $o->mediaurl);
        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);
        $this->view->setVars(array(
            'checklink' => $checklink,
            'object' => $o,
            'currentLink' => DOMAIN . Helper::cpagerparm("")
        ));
        $this->view->header = Helper::setHeader($o->name,$o->description, $o->priavatar);
    }

}

