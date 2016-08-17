<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\ReportSpam;

class ReportspamController extends ControllerBase {

    public function indexAction() {
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
        $listFeedback = ReportSpam::findWithFullInfor($criteria);
        $count = ReportSpam::count($query);
        $this->view->listFeedback = $listFeedback;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "/reportspam/form"),
            "delete" => Helper::cpagerparm("tact,id", "/reportspam/delete"),
            "rolegroup" => Helper::cpagerparm("tact,id", "/reportspam/rolegroup"),
        );
    }

    public function deleteAction() {
        $id = $this->request->get('id');
        if (is_array($id)) { //delete in
            $id = array_map("strval", $id);
            ReportSpam::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        }
        if ($id) ReportSpam::deleteDocument(array('_id' => $id));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/reportspam/index");
        if (!$redirect) $redirect = '/reportspam/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

}