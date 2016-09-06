<?php
/**
 * Created by PhpStorm.
 * User: hungln6
 * Date: 9/24/2015
 * Time: 9:35 AM
 */
namespace DjCms\Controller;
use DjCms\Library\Helper;
use DjCms\Models\Answer;
use DjCms\Models\Users;

class AnswerController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        #Query
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        ## Filter
        if (!empty($keyword)) {
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        ## bind Data
        $paramsQuery = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array('sort' => 1),
        );
        $listmedia = Answer::findAndReturnArray($paramsQuery);
        try {
            foreach ($listmedia as $key => $item) {
                $userid = $item['usercreate'];
                $userInfo = Users::findById($userid);
                $listmedia[$key]['usercreate'] = $userInfo->username;
                // if (!empty($listmedia[$key]['priavatar']))
                //     $listmedia[$key]['priavatar'] = $this->getRealPathImage($listmedia[$key]['priavatar']);
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $count = Answer::count(array($query));
        $this->view->listmedia = $listmedia;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "form"),
            "delete" => Helper::cpagerparm("tact,id", "delete")
        );
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        ##Answer
        $o = (array)Answer::findById($id);
        $this->view->object = $o;
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/answer/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            $postvalue = Helper::post_to_array("name,content,sort");
            $postvalue['sort'] = intval($postvalue['sort']);
            if ($id <= 0) {
                $postvalue['_id'] = strval(strtotime("now"));
                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['usercreate'] = $uinfo['_id'];
                Answer::insertDocument($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                Answer::updateDocument(array('_id' => $id), array('$set' => $postvalue));
                $this->flash->success($this->getLanguage()->update_success);
            }

            $redirect = $this->request->getPost("redirect");
            if (!$redirect) $redirect = "answer/index";
            return $this->response->redirect(ltrim($redirect, "/"));
        } else $redirect = "answer/index";
        return $this->response->redirect(ltrim($redirect, "/"));
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Answer::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        } else  Answer::deleteDocument(array('_id' => "$id"));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/answer/index");
        if (!$redirect) $redirect = '/answer/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

}