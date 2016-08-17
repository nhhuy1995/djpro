<?php
namespace DjCms\Controller;

use DjCms\Models\Media;
use DjCms\Library\Helper;
use DjCms\Models\Album;
use DjCms\Models\Tag;
use DjCms\Models\Topic;
use DjCms\Models\Users;

class TopicController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $type = $_GET['type'];
        $catid = $_GET['catid'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        #Query
        $query = array();
        if ($keyword) $query = array('$text' => array('$search' => "\"$keyword\""));
        ## bind Data
        $paramsQuery = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array('_id' => -1),
        );
        $listTopic = Topic::findAndReturnArray($paramsQuery);
        foreach ($listTopic as $key => $item) {
            $listTopic[$key]['countsong'] = count($item['listsong']);
            $listTopic[$key]['priavatar'] = $this->getRealPathImage($listTopic[$key]['priavatar']);
            $userObj = Users::findById($item['usercreate']);
            if (!$userObj) {
                $listTopic[$key]['usercreate'] = array(
                    "_id" => "",
                    "username" => "<span style='color: red'>Not Found</span>"
                );
            } else {
                $listTopic[$key]['usercreate'] = array(
                    "_id" => $userObj->getId(),
                    "username" => $userObj->username
                );
            }
        }
        $this->view->listtopic = $listTopic;
        $this->view->painginfo = Helper::paginginfo(Album::count(), $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "form"),
            "delete" => Helper::cpagerparm("tact,id", "delete")
        );
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        ##News
        $o = (array)Topic::findById($id);
        $o['note'] = Helper::br2nl($o['note']);
        if (!is_array($o['tags']) || !count($o['tags']))
            $o['tags'] = array();
        $criteria = array(
            "condition" => array("_id" => array('$in' => $o['tags'])),
            "fields" => array("name", "_id")
        );
        $listTagCr = Tag::findAndReturnArray($criteria);
        $o['tags'] = $listTagCr;
        if (!$o['listsong'] && strlen($id))
            $o['listsong'] = array();
        if (count($o['listsong'])) {
            $criteria = array(
                    "condition" => array(
                            "_id" => array('$in' => $o['listsong'])
                    ),
                    "fields" => array("_id", "name")
            );
            $listSongs = Media::findAndReturnArray($criteria);
            $listSongs = Helper::resortarray($listSongs, $o['listsong'], "_id");
            $o['listsong'] = $listSongs;
        }
        $this->view->object = $o;
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/topic/index");
    }

    public function formprocessAction()
    {
//        $dbmg = $this->getConnection();
//        $mediacl = $dbmg->media;
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $uinfo = (array)$this->session->get("uinfo");

            $postvalue = Helper::post_to_array("name,description,sort,avatar_topic,background_topic,status,view,like,replay,spamflag,priavatar,listsong");
            $postvalue['sort'] = intval($postvalue['sort']);
            $postvalue['view'] = intval($postvalue['view']);
            $postvalue['like'] = intval($postvalue['like']);
            $postvalue['replay'] = intval($postvalue['replay']);
            $postvalue['spamflag'] = intval($postvalue['spamflag']);
            $postvalue['tags'] = $this->request->getPost('tags');
            $postvalue['status'] = $postvalue['status'] <= 0 ? 0 : 1;
            $postvalue['namenonutf'] = Helper::convertToUtf8($postvalue['name']);
            $postvalue['listsong'] = array_values($postvalue['listsong']);
            #Avatar + Status
            $priavatar = $this->post_file_to_array();
            if (!strlen($postvalue['priavatar']) && $priavatar != null) $postvalue['priavatar'] = $priavatar;
            $postvalue['priavatar'] = $this->getShortenPathImage($postvalue['priavatar']);

            ##Process
            if ($id <= 0) {
                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['_id'] = strval(strtotime("now"));
                Topic::insertDocument($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                $condition = array('_id' => $id);
                $updateValues = array(
                    '$set' => $postvalue,
                    '$push' => array(
                        "usermodify" => array(
                            "uid" => $uinfo['_id'],
                            "datecreate" => intval(strtotime("now"))
                        )
                    )
                );
                Topic::updateDocument($condition, $updateValues);
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->getPost("redirect");
            if (!$redirect) $redirect = "topic/index";
            return $this->response->redirect(ltrim($redirect, "/"));
        } else $redirect = "topic/index";
        return $this->response->redirect(ltrim($redirect, "/"));
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Album::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        } else  Album::deleteDocument(array('_id' => "$id"));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/album/index");
        if (!$redirect) $redirect = '/album/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }
}