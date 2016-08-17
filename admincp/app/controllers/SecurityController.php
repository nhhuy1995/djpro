<?php
namespace DjCms\Controller;

use DjCms\Library\Module;
use DjCms\Library\Helper;
use DjCms\Models\Role;
use DjCms\Models\Users;

class SecurityController extends ControllerBase {
    public function loginAction(){
        $this->view->setMainView("login");
        if($this->request->hasPost("username")){
            $postdata = Helper::post_to_array("username,password");

            $uinfo = Users::findFirst(array(
                array(
                    "username"=>$postdata['username'],
                    "password"=>Helper::encryptpassword($postdata['password'])
                )
            ));
            if(!empty($uinfo->_id)) {
                $this->session->set("uinfo",$uinfo);
                // Role
                if(count($uinfo->role)<=0) $uinfo->role =array();
                $listrole = Role::findAndReturnArray(array(
                    "condition" => array("_id"=>array('$in'=>$uinfo->role))
                ));
                $this->session->set("listrole",$listrole);
                $permission = array();
                foreach ($listrole as $item) $permission += $item['permission'];
                $this->session->set("permission",$permission);
                // Check login permission
                $module = new Module();
                if($module->is_accept_permission("loginsystem")==1){
                    $this->response->redirect("media/index");
                }
                else{
                    $this->flash->error("Bạn không đủ quyền hạn để truy cập module này");
                }
            }
            else {
                $this->flash->error("Không tìm thấy tài khoản tồn tại");
            }
        }
    }

    public function logoutAction(){
        $this->session->destroy();
        $this->response->redirect("security/login");
    }

    public function messageAction(){
        $this->view->setMainView("index");
    }
}
?>