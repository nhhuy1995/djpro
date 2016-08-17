<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\Album;
use DjCms\Models\Category;

class CategoryController extends ControllerBase
{

    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $parentid = $_GET['parentid'];
        $type = $_GET['type'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        if (!empty($keyword) && !empty($type)) {
            $query['$or'][] = array('$text' => array('$search' => "\"$keyword\""));
            $query['$or'][] = array('_id' => $keyword);
            $query['$and'][] = array('type' => $type);
        } else {
            if ($keyword) {
                $query = array('$or' => array(
                    array('$text' => array('$search' => "\"$keyword\"")),
                    array('_id' => $keyword),
                ));
            }
            if ($type) {
                $query = array('$or' => array(
                    array('type' => $type)
                ));
            }
        }
        if (isset($parentid)) $query['parentid'] = $parentid;
        $paramsQuery = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit
        );
        $paramsQuery['sort'] = array("sort" => 1);

        $listcategory = Category::findAndReturnArray($paramsQuery);
        $list_type = Category::list_type();
        foreach ($listcategory as &$item) {
            $item['typename'] = $list_type[$item['type']];
        }
        $count = Category::count();

        $this->view->list_type = $list_type;
        $this->view->listcategory = $listcategory;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "/category/form"),
            "delete" => Helper::cpagerparm("tact,id", "/category/delete"),
        );
    }

    public function formAction()
    {
        $id = $this->request->get('id');
        ## Process
        $o = (array)Category::findById($id);
        if (isset($o['parentid'])) {
            $parent = (array)Category::findById($o['parentid']);
        }
        $list_type = Category::list_type();
        $this->view->object = $o;
        $this->view->list_type = $list_type;
        $this->view->parent = $parent;
        $this->view->backlink = $this->view->backlink = Helper::cpagerparm("tact,id,status", "/category/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            #Process
            $categorycl = Category::getCollectionInstance();
            $postvalue = Helper::post_to_array('name,type,status,parentid,is_topic,priavatar');
            $postvalue['status'] = $postvalue['status'] <= 0 ? 0 : 1;
            $postvalue['is_topic'] = strlen($postvalue['is_topic']) <= 0 ? false : true;
            $postvalue['sort'] = 9999;
            if (empty($postvalue['parentid'])) $postvalue['parentid'] = '0';
            ##Session
            $uinfo = (array)$this->session->get("uinfo");
            ##Process

            if ($id <= 0) {
                $postvalue['_id'] = strval(strtotime('now'));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['datecreate'] = intval(strtotime('now'));
                $categorycl->insert($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                $categorycl->update(array('_id' => $id), array('$set' => $postvalue));
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/category/index";
            return $this->response->redirect(ltrim($redirect, '/'));
        }
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Category::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        } else  Category::deleteDocument(array('_id' => "$id"));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/category/index");
        if (!$redirect) $redirect = '/category/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

    public function articleAction()
    {
        $catid = $this->request->get('catid');
        $listtopic = Album::findAndReturnArray(array(
            'fields' => array('_id', 'name', 'datecreate', 'sort', 'priavatar'),
            'condition' => array('category' => $catid),
            'sort' => array('sort' => 1),
        ));
        if ($this->request->isPost()) {
            $listid = $this->request->get('listtopicid');
            $listidEnable = $this->request->get('topicid');
            foreach ($listidEnable as $key => $val) {
                $index = $key + 1;
                Album::updateDocument(array('_id' => $val), array('$set' => array('sort' => $index)));
            }
            if($listidEnable == null || !isset($listidEnable)) $listidRemove = $listid;
            else $listidRemove = array_diff($listid,$listidEnable);
            if(!empty($listidRemove)) Category::reMoveCateIDInTopic(array_values($listidRemove),$catid);
            return $this->response->redirect("/category/article?catid=$catid");
        }
        $this->view->listtopic = $listtopic;
    }
    public function categoryspecialAction()
    {
        $listcategory = Category::findAndReturnArray(array(
            'condition' => array('type' => 'topic','is_topic' => true, 'status' => 1),
            'sort' => array('sort' => 1),
        ));
        if ($this->request->isPost()) {
            $listid = $this->request->get('listcategoryid');
            $listidEnable = $this->request->get('categoryid');
            foreach ($listidEnable as $key => $val) {
                $index = $key + 1;
                Category::updateDocument(array('_id' => $val), array('$set' => array('sort' => $index)));
            }
            if($listidEnable == null || !isset($listidEnable)) $listidRemove = $listid;
            else $listidRemove = array_diff($listid,$listidEnable);

            if(!empty($listidRemove)){
                $listidRemove = array_values($listidRemove);
                Category::updateDocument(
                    array('_id' => array('$in' => $listidRemove)),
                    array('$set' => array('is_topic' => false)),
                    array('multiple' => true)
                );
            }

            return $this->response->redirect("/category/categoryspecial");
        }
        $this->view->listcategory = $listcategory;
    }
}

