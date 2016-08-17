<?php
namespace DjCms\Controller;

use DjCms\Models\Tag;
use DjCms\Library\Helper;
use DjCms\Models\Users;

/**
 * Class TagController
 * @package DjCms\Controller
 * Crud for tag in news, video, ...
 */
class TagController extends ControllerBase
{

    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        ## Filter
        if (!empty($keyword)) {
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        $criteria = array(
            "condition" => $query,
            "sort" => $cp,
            "limit" => $limit,
            "sort" => array("datecreate" => -1)
        );
        $listTags = Tag::findAndReturnArray($criteria);
        foreach ($listTags as $key => $item) {
            $userObj = Users::findById($item['usercreate']);
            $listTags[$key]['usercreate'] = array(
                "_id" => $userObj->getId(),
                "username" => $userObj->username
            );
        }
        $this->view->listTags = $listTags;
        $this->view->painginfo = Helper::paginginfo(Tag::count($query), $limit, $p);
        $this->view->controllink = array("update" => Helper::cpagerparm("tact,id", "/tag/form"), "delete" => Helper::cpagerparm("tact,id", "/tag/delete"));
    }

    public function formAction()
    {
        $id = $this->request->get('id');
        $tagCl = Tag::getCollectionInstance();
        $o = (array)$tagCl->findOne(array("_id" => "$id"));
        $this->view->object = $o;
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/tag/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            #Process
            $tagCl = Tag::getCollectionInstance();
            $postvalue = Helper::post_to_array('name');
            $postvalue['namenonaccent'] = strtolower(Helper::convertToUtf8($postvalue['name']));

            $postvalue['lower_name'] =  mb_convert_case($name, MB_CASE_LOWER, 'UTF-8');
            ##Session
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            if ($id <= 0) {
                $postvalue['_id'] = strval(strtotime('now'));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['datecreate'] = intval(strtotime('now'));
                $tagCl->insert($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                $tagCl->update(array('_id' => $id), array('$set' => $postvalue));
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/tag/index";
            return $this->response->redirect(ltrim($redirect, '/'));
        }

    }

    public function deleteAction()
    {
        $tagCl = Tag::getCollectionInstance();
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            $tagCl->remove(array('_id' => array('$in' => $id)), array('multiple' => true));
        } else  $tagCl->remove(array('_id' => "$id"));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/tag/index");
        if (!$redirect) $redirect = '/tag/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }
}