<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\Album;
use DjCms\Models\Artist;
use DjCms\Models\Category;
use DjCms\Models\Media;
use DjCms\Models\ReportSpam;
use DjCms\Models\Tag;
use DjCms\Models\Users;

class AlbumController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $type = $_GET['type'];
        $catid = $_GET['catid'];
        $status = $_GET['status'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        #Query
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        $querycategory = array('category' => $catid);
        $querystatus = array('status' => intval($status));
        $querytype = array('type' => $type);
        ## Filter
        if(!empty($keyword)){
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        if(!empty($type))  $query['$and'][] = $querytype;
        if(!empty($catid))  $query['$and'][] = $querycategory;
        if(!empty($status))  $query['$and'][] = $querystatus;

        ## bind Data
        $paramsQuery = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array('_id' => -1),
        );
        $listAlbum = Album::findAndReturnArray($paramsQuery);
        $listCategory = Category::findAndReturnArray(array());
        foreach ($listAlbum as $key => $item) {
            $listAlbum[$key]['countsong'] = count($item['listsong']);
            $catids = $item['category'];
            if (!empty($catids)) {
                foreach ($catids as $elem) if ($listCategory[$elem]) $catName[] = $listCategory[$elem]['name'];
            }
            $listAlbum[$key]['categoryname'] = $catName;
            unset($catids, $catName);
            $userObj = Users::findById($item['usercreate']);
            if (!$userObj) {
                $listAlbum[$key]['usercreate'] = array(
                    "_id" => "",
                    "username" => "<span style='color: red'>Not Found</span>"
                );
            } else {
                $listAlbum[$key]['usercreate'] = array(
                    "_id" => $userObj->getId(),
                    "username" => $userObj->username
                );
            }
        }
        ## list category
        $listCategory = Category::findAndReturnArray(array('condition' => array('type' => array('$in' => array('album','playlist','topic')))));

        $this->view->listAlbum = $listAlbum;
        $this->view->listCategory = $listCategory;
        $this->view->liststatus = Helper::getListStatus();
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
        $o = (array)Album::findById($id);
        ##warning media
        if (isset($id)) {
            $media_Warning = ReportSpam::count(array(
                'conditions' => array('atid' => $o['_id'], 'type' => $o['type'])
            ));
            $o['spamflag'] = $media_Warning;
        }
        $o['note'] = Helper::br2nl($o['note']);
        if (!is_array($o['tags']) || !count($o['tags']))
            $o['tags'] = array();
        if (!is_array($o['artist']) || !count($o['artist']))
            $o['artist'] = array();
        $criteria = array(
            "condition" => array("_id" => array('$in' => $o['tags'])),
            "fields" => array("name", "_id")
        );

        $listTagCr = Tag::findAndReturnArray($criteria);
        $listTagCr = Helper::resortarray($listTagCr, $o['tags'], '_id');
        $listArtistCr = Artist::findAndReturnArray(array(
            "condition" => array('_id' => array('$in' => $o['artist'])),
        ));
        $listArtistCr = Helper::resortarray($listArtistCr, $o['artist'], '_id');
        $o['artist'] = $listArtistCr;
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

        $this->view->liststatus = Helper::getListStatus();
        $this->view->object = $o;
        $this->view->categoryview = Category::recursive_to_html(array('type' => array('$in' => array('playlist','topic','album'))), "category[]", $o['category']);
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/album/index");
    }

    public function formprocessAction()
    {
//        $dbmg = $this->getConnection();
//        $mediacl = $dbmg->media;
        ini_set('display_errors', true);
        error_reporting(E_ALL);
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $uinfo = (array)$this->session->get("uinfo");

            $postvalue = Helper::post_to_array("name,description,sort,content,artist,type,isspecial,source,status,view,album,banner,small_banner,priavatar,listsong,tags,category");
            $postvalue['view'] = intval($postvalue['view']);
            $postvalue['sort'] = $postvalue['sort'] <= 0 ? 9999 : intval($postvalue['sort']);
            $postvalue['isspecial'] = $postvalue['isspecial'] <= 0 ? 0 : intval($postvalue['isspecial']);
            $postvalue['tags'] = $this->request->getPost('tags');
            $postvalue['status'] = intval($postvalue['status']);
            $postvalue['namenonutf'] = Helper::convertToUtf8($postvalue['name']);
            $postvalue['listsong'] = array_values($postvalue['listsong']);
            $uinfo = (array) $this->session->get("uinfo");
            if(isset($postvalue['tags']) && !empty($postvalue['tags'])) {
                $postvalue['tags'] = Tag::standardListTag($postvalue['tags'], $uinfo['_id']);
            }
            $postvalue['artist'] = $this->request->getPost('artist');
            if (isset($postvalue['artist']) && !empty($postvalue['artist'])) {
                if ($postvalue['status'] == 1)
                    $newStatus = Artist::$_STATUS_ACTIVE;
                else
                    $newStatus = Artist::$_STATUS_WAIT;

                $postvalue['artist'] = Artist::standardListArtist($postvalue['artist'], $uinfo['_id'], $newStatus);

            }

            #Avatar
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

            if (!strlen($postvalue['small_banner']) && $priavatar['small_banner'] != null) {
                $postvalue['small_banner'] = $priavatar['small_banner'];
                $postvalue['small_banner'] = $this->getShortenPathImage($postvalue['small_banner']);
            } else {
                unset($postvalue['small_banner']);
            }
            ##Process
            if ($id <= 0) {

                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['_id'] = strval(strtotime("now"));
                Album::insertDocument($postvalue);
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
                Album::updateDocument($condition, $updateValues);
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->getPost("redirect");
            if (!$redirect) $redirect = "album/index";
            return $this->response->redirect(ltrim($redirect, "/"));
        } else $redirect = "album/index";
        return $this->response->redirect(ltrim($redirect, "/"));
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Album::updateDocument(array('_id' => array('$in' => $id)),array('$set' => array('status' => 2)), array('multiple' => true));
        } else  Album::updateDocument(array('_id' => "$id"), array('$set' => array('status' => 2)));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/album/index");
        if (!$redirect) $redirect = '/album/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }
    public function topicisspecialAction(){
        $listtopic = Album::findAndReturnArray(array(
            'fields' => array('_id', 'name', 'datecreate', 'sort', 'priavatar','isspecial'),
            'condition' => array('isspecial' => 1),
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

            if(!empty($listidRemove)){
                $listidRemove = array_values($listidRemove);
                Album::updateDocument(
                    array('_id' => array('$in' => $listidRemove)),
                    array('$set' => array('isspecial' => 0)),
                    array('multiple' => true)
                );
            }
            return $this->response->redirect("/album/topicisspecial");
        }
        $this->view->listtopic = $listtopic;
    }
}