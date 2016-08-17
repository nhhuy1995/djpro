<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\Artist;
use DjCms\Models\Category;

class ArtistController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $catid = $_GET['catid'];
        $status = $_GET['status'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        $querycategory = array('category' => $catid);
        $querystatus = array('status' => intval($status));
        ## Filter
        if (!empty($keyword)) {
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        if (!empty($catid))  $query['$and'][] = $querycategory;
        if (!empty($status)) $query['$and'][] = $querystatus;
        $criteria = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array("datecreate" => -1)
        );
        $listCategory = Category::findAndReturnArray(array('condition' => array('type' => 'artist')), true);
        $listArtist = Artist::findAndReturnArray($criteria);
        foreach ($listArtist as $key => $item) {
            $catids = $item['category'];
            if (!empty($catids)) {
                foreach ($catids as $elem){
                    if ($listCategory[$elem]) $catName[] = $listCategory[$elem]['name'];
                }
            }
            $listArtist[$key]['categoryname'] = $catName;
            unset($catids, $catName);
        }
        $count = Artist::count(array($query));
        $this->view->listArtist = $listArtist;
        $this->view->listCategory = $listCategory;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->liststatus = Helper::getListStatus();
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "/artist/form"),
            "delete" => Helper::cpagerparm("tact,id", "/artist/delete"),
            "rolegroup" => Helper::cpagerparm("tact,id", "/artist/rolegroup"),
        );
    }

    public function formAction()
    {
        $artistcl = Artist::getCollectionInstance();
        $id = $this->request->get('id');
        #Process
        $o = (array)$artistcl->findOne(array('_id' => $id));
        $o['type'] = array_combine($o['type'], $o['type']);
        if (!$o['type']) $o['type'] = array();
        $this->view->object = $o;
        $this->view->liststatus = Helper::getListStatus();
        $this->view->backlink = $this->view->backlink = Helper::cpagerparm("tact,id,status", "/artist/index");
        $this->view->categoryview = Category::recursive_to_html(array('type' => 'artist'), "category[]", $o['category']);
        $this->view->artistTypes = Artist::getAllArtistTypes();

    }
    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            #Process
            $postvalue = Helper::post_to_array('realname,username,from,birthday,job,playmusic,yearjob,clubdid,workingat,hobby,facebook,sex,status,priavatar,description,content,type,category,banner');
            #Avatar
            $postvalue['status'] = intval($postvalue['status']);
            $postvalue['description'] = htmlspecialchars($postvalue['description']);
            $priavatar = $this->post_file_to_array(true);
            if (!strlen($postvalue['priavatar']) && $priavatar['priavatar'] != null) {
                $postvalue['priavatar'] = $priavatar['priavatar'];
                $postvalue['priavatar'] = $this->getShortenPathImage($postvalue['priavatar']);
            } else {
                unset($postvalue['priavatar']);
            }

            if (!strlen($postvalue['banner']) && $priavatar['banner'] != null) {
                $postvalue['banner'] = $priavatar['banner'];
                $postvalue['banner'] = $this->getShortenPathImage($postvalue['banner']);
            } else {
                unset($postvalue['banner']);
            }

            $postvalue['namenonutf'] = strtolower(Helper::convertToUtf8($postvalue['username']));
            $postvalue['lower_name'] = mb_convert_case($postvalue['username'], MB_CASE_LOWER, 'UTF-8');
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            if ($id <= 0) {
                $postvalue['_id'] = strval(strtotime('now'));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['datecreate'] = intval(strtotime('now'));
                $postvalue['add_new'] = 1;
                Artist::insertDocument($postvalue);
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
                Artist::updateDocument($criteria, $updateValuess);
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/artist/index";
            return $this->response->redirect(ltrim($redirect, '/'));
        }
    }
    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Artist::updateDocument(array('_id' => array('$in' => $id)), array('$set' => array('status' => 2)), array('multiple' => true));
        } else  Artist::updateDocument(array('_id' => "$id"),array('$set' => array('status' => 2)));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/artist/index");
        if (!$redirect) $redirect = '/artist/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }
}