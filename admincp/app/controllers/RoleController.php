<?php
namespace DjCms\Controller;
use DjCms\Library\Helper;
use DjCms\Library\Module;
use DjCms\Models\Role;

class RoleController extends ControllerBase
{

    public function indexAction()
    {
        $keyword = $this->request->get('q');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        $query = array();
        if(strlen($keyword)>0) $query = array('$text'=>array('$search'=>"\"$keyword\""));
        $listRoles = Role::findAndReturnArray(array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array("sort" => 1)
        ));

        $count = Role::count($query);
//        var_dump($listRoles);die;
        $this->view->listRole = $listRoles;
        $this->view->painginfo = Helper::paginginfo($count,$limit, $p);
        $this->view->controllink = array("update" => Helper::cpagerparm("tact,id", "/role/form"), "delete" => Helper::cpagerparm("tact,id", "/role/delete"));
    }

    public function formAction()
    {
        $id = $this->request->get('id');
        ## Process
        $helper = new Module();
        $module = $helper->Permission();
        $roleCl = Role::getCollectionInstance();
        if ($id) {
            $roleInfo = $roleCl->findOne(array('_id' => $id));
        }
        $list_permission = $roleInfo['permission'];
        //set active for rolegroup
        foreach ($module as $key => $item) {
            if (in_array($key, $list_permission)) $module[$key]['checked'] = 'checked';
            else $module[$key]['checked'] = '';
            foreach ($item['child'] as $ckey => $val) {
                if (in_array($key . "_" . $val['key'], $list_permission)) $module[$key]['child'][$ckey]['checked'] = "checked";
                else $module[$key]['child'][$ckey]['checked'] = "";
            }
        }
        $this->view->module = $module;
        $this->view->roleInfo = $roleInfo;
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/role/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->get('id');
            ##Check Permission
            $permissionrs = strlen($id) > 0? $this->checkpermission("role_update"):$this->checkpermission("role_add");
            if ($permissionrs == 0) return false;
            ## Process
            $postvalue = Helper::post_to_array("name,sort,permission");
            $postvalue['sort'] = intval($postvalue['sort']);
            if ($this->_hasSystemPermission($postvalue['permission']))
                array_push($postvalue['permission'], "system");
            ##Process
            if ($id <= 0) {
                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['_id'] = strval(strtotime("now"));
                Role::insertDocument($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                Role::updateDocument(array('_id' => $id), array('$set' => $postvalue));
                $this->flash->success($this->getLanguage()->update_success);
            }
            $redirect = $this->request->get("redirect");
            if (!$redirect) $redirect = "/role/index";
            return $this->response->redirect(ltrim($redirect,'/'));
        }
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        if (is_array($id)) { //delete in
            $id = array_map("strval", $id);
            Role::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        }
        if ($id) Role::deleteDocument(array('_id' => $id));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/role/index");
        if (!$redirect) $redirect = '/role/index';
        return $this->response->redirect(ltrim($redirect,'/'));
    }

    protected function _hasSystemPermission($permission) {
        $matches  = preg_grep ('/^user_(\w+)/i', $permission);
        if (count($matches))
            return true;
        $matches  = preg_grep ('/^role_(\w+)/i', $permission);
        if (count($matches))
            return true;
        else return false;
    }
}

