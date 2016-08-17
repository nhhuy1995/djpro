<?php
/**
 * Created by PhpStorm.
 * User: hungln6
 * Date: 9/24/2015
 * Time: 9:35 AM
 */
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Models\Role;
use DjCms\Models\Users;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        if(strlen($keyword)>0) $query = array('$text'=>array('$search'=>"\"$keyword\""));
        $criteria = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array("datecreate" => -1)
        );
        $list_user = Users::findAndReturnArray($criteria);
        $count = Users::count();
        $this->view->listUser = $list_user;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
                "update" => Helper::cpagerparm("tact,id", "/users/form"),
                "delete" => Helper::cpagerparm("tact,id", "/users/delete"),
                "rolegroup" => Helper::cpagerparm("tact,id", "/users/rolegroup"),
        );
    }

    public function formAction()
    {
        $usercl = Users::getCollectionInstance();
        $id = $this->request->get('id');
        #Process
        $userInfo = $usercl->findOne(array('_id' => $id));
        $userInfo['priavatar'] = $this->getRealPathImage( $userInfo['priavatar']);
        $this->view->userInfo = $userInfo;
        $this->view->backlink = $this->view->backlink = Helper::cpagerparm("tact,id,status", "/users/index");

    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            #Process
            $postvalue = Helper::post_to_array('username,password,email,fullname,address,phone,days,month,year,facebook,yahoo,skype,job,hobby,sex');
            if(strlen($postvalue['password'] <=0)) unset($postvalue['password']);
            else $postvalue['password'] = Helper::encryptpassword($postvalue['password']);
            $postvalue['days'] = intval($postvalue['days']);
            $postvalue['month'] = intval($postvalue['month']);
            $postvalue['year'] = intval($postvalue['year']);
            #Avatar
            $priavatar = $this->post_file_to_array();
            if (!strlen($postvalue['priavatar']) && $priavatar != null) $postvalue['priavatar'] = $priavatar;
            $postvalue['priavatar'] = 'http://dj.pro.vn/web/'.$postvalue['priavatar'];
            $postvalue['priavatar'] = $this->getShortenPathImage($postvalue['priavatar']);
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            if ($id <= 0) {
                $postvalue['_id'] = strval(strtotime('now'));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['datecreate'] = intval(strtotime('now'));
                Users::insertDocument($postvalue);
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
                Users::updateDocument($criteria, $updateValuess);
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/users/index";
            return $this->response->redirect(ltrim($redirect,'/'));
        }
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { //delete in
            $id = array_map("strval", $id);
            Users::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        }
        if ($id) Users::deleteDocument(array('_id' => $id));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/users/index");
        if (!$redirect) $redirect = '/users/index';
        return $this->response->redirect(ltrim($redirect,'/'));
    }

    public function rolegroupAction()
    {
        $keyword = $this->request->get('q');
        $id = $this->request->get('id');
        $role = $this->request->get('role');
        ## User info
        $o = Users::findById($id);
        $rolegroup_id = $o->role;
        ##Add permission for user
        if ($this->request->isPost()) {
            Users::updateDocument(array('_id' => $id), array('$set' => array("role" => $role)));
            $this->flash->success("Xử lý thành công");
            return $this->response->redirect('/users/index');
        }

        ##List role_group
        $criteria = array(
            "condition" => array('name' => array('$regex' => new \MongoRegex("/$keyword/iu"))),
            "sort" => array("sort" => 1)
        );

        $listroles = Role::findAndReturnArray($criteria);
        $data = array();
        foreach ($listroles as $key => $item) {
            if (in_array($item['_id'], $rolegroup_id)) $item['checked'] = 'checked';
            else $item['checked'] = '';
            $data[] = $item;
        }
        $this->view->listRole = $data;
    }
}