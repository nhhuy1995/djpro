<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\Comment;

class CommentController extends ControllerBase {

    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        if (strlen($keyword) > 0)
//            $query = array('$text' => array('$search' => "\"$keyword\""));
            $query = array('content' => new \MongoRegex('/'.$keyword.'/'));

        $atid = $this->request->get('atid');
        if (!empty($atid)) {
            $query['atid'] = $atid;
        }
        $pid = $this->request->get('pid');
        if (!empty($pid)) {
            $query['parent_id'] = $pid;
        }
        $uid = $this->request->get('uid');
        if (!empty($pid)) {
            $query['user_id'] = $uid;
        }

        $criteria = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array("datecreate" => -1)
        );
        $listComment = Comment::findWithFullInfor($criteria);
        $count = Comment::count($query);
        $this->view->listComment = $listComment;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "/comment/form"),
            "delete" => Helper::cpagerparm("tact,id", "/comment/delete"),
            "rolegroup" => Helper::cpagerparm("tact,id", "/comment/rolegroup"),
        );
    }

    public function formAction()
    {
        $commentCl = Comment::getCollectionInstance();
        $id = $this->request->get('id');
        #Process
        $commentInfor = (array)$commentCl->findOne(array('_id' => $id));
        $this->view->commentInfor = $commentInfor;
        $this->view->backlink = $this->view->backlink = Helper::cpagerparm("tact,id,status", "/comment/index");

    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            #Process
            $postvalue = Helper::post_to_array('content');
            $postvalue['content'] = htmlspecialchars($postvalue['content']);
            ##Process
            $uinfo = (array)$this->session->get("uinfo");
            if ($id <= 0) {
//                $postvalue['_id'] = strval(strtotime('now'));
//                $postvalue['usercreate'] = $uinfo['_id'];
//                $postvalue['datecreate'] = intval(strtotime('now'));
//                Comment::insertDocument($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                $criteria = array('_id' => $id);
                $updateValuess = array(
                    '$set' => $postvalue,
                    '$push' => array(
                        "modifyuser" => $uinfo['_id'],
                        "modifydate" => intval(strtotime("now"))
                    )
                );
                Comment::updateDocument($criteria, $updateValuess);
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/comment";
            return $this->response->redirect(ltrim($redirect, '/'));
        }
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { //delete in
            $id = array_map("strval", $id);
            Comment::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        }
        if ($id) Comment::deleteDocument(array('_id' => $id));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/comment/index");
        if (!$redirect) $redirect = '/comment/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

}