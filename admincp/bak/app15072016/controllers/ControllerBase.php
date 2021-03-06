<?php
namespace DjCms\Controller;

use DjCms\Lang\viVN;
use DjCms\Library\Helper;
use DjCms\Service\FrontEndComponent;
use DjCms\Library\Module;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{

    protected $viewComponent;

    protected $actionNotNeedCheck = array(
        'security_message',
        'security_login',
        'security_logout'
    );
    protected $ownActionIgnoreCheckPermission;

    protected function initialize()
    { 
        $sidebar = Module::Sidebar();
        $controller = strtolower($this->router->getControllerName());
        $action = $this->router->getActionName();
        $permission = $this->session->get("permission");

        if (!$this->session->has("uinfo")) {
            if (strtolower($controller . "/" . $action) != "security/login") $this->response->redirect("security/login");
        } else {
            $permission = $this->session->get("permission");
            foreach ($sidebar as $key => &$item)
                $this->bindActiveSidebar($item, $controller, $permission);

            $this->view->sidebar = $sidebar; //$this->refacterSideBar($sidebar);
            if (!$this->viewComponent) {
                $this->viewComponent = new FrontEndComponent();
            }
        }

    }


    /**
     * @param Dispatcher $dispatcher
     * @return bool
     * Check permission before any execution of route
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        $keyAction = $this->createKeyActionToCheckPermission($controllerName, $actionName);
        if (is_int(array_search($keyAction, $this->ownActionIgnoreCheckPermission))) return true;
        if (is_int(array_search($keyAction, $this->actionNotNeedCheck))) return true;
        if (!$this->checkpermission($keyAction)) {
            return false;
        }
    }

    /**
     * @param $controllerName Name of controller
     * @param $actionName Name of action
     * @return string key to check permission
     * Create key to check permission
     */
    protected function createKeyActionToCheckPermission($controllerName, $actionName)
    {
        if ($actionName == "index")
            $actionName = "view";
        if ($actionName == "form" || $actionName == "formprocess")
            $actionName = "add";
        $keyAction = $controllerName . "_" . $actionName;
        return $keyAction;
    }

    public function afterExecuteRoute()
    {
        if ($this->dispatcher->isFinished()) {

        }
    }

    public function refacterSideBar($sidebar)
    {
        $sidebar = array_values($sidebar);
        foreach ($sidebar as $k => &$v) {
            if (isset($v['unset']))
                unset($sidebar[$k]);

            if (isset($v['child']))
                foreach ($v['child'] as $_k => $_v)
                    if (isset($_v['unset']))
                        unset($sidebar[$k]['child'][$_k]);
        }

        return $sidebar;
    }

    public function bindActiveSidebar(&$item, $controller, $permission, $issub = false)
    {
        // default controller
        $item['active'] = ($item['controller'] == "/index/index" && $controller == "index") ? "active toggled" : "";
        $itemkey = explode(",", $item['key']);
        ##Check permission
        if (!in_array("all", $permission)) {
            if (count(array_intersect($permission, $itemkey)) <= 0) {
                $item['unset'] = true;
            } else {
                in_array($controller, $itemkey) ? $item['active'] = "active toggled" : $item['active'] = "";
                $item['controller'] = $this->config->application->baseUri . $item['controller'];
            }
        } else {
            in_array($controller, $itemkey) ? $item['active'] = "active toggled" : $item['active'] = "";
            $item['controller'] = $this->config->application->baseUri . $item['controller'];
        }
        $item['controller'] = str_replace("//", "/", $item['controller']); // remove duplicated char
        if (isset($item['child']) && !empty($item['child'])) {
            // process child menu
            foreach ($item['child'] as $_k => &$_v) {
                $this->bindActiveSidebar($_v, $controller, $permission, true);
            }
        }
    }

    public function post_file_to_array($returnarray = false)
    {
        $listimage = null;
        $priavatar = null;
        if ($this->request->hasFiles() == true) {
            $uploaddir = $this->config->upload->dir;
            $allow = (array)$this->config->upload->extension;
            $folder = "uploads/" . date("Y/m/d/");
            if (!file_exists($uploaddir . $folder)) mkdir($uploaddir . $folder, 0777, true);
            $uploads = $this->request->getUploadedFiles(); 
            
            foreach ($uploads as $upload) {
                if (in_array($upload->getType(), $allow)) {
                    $filename = md5(uniqid(rand(), true)) . '_' . strtolower($upload->getname());
                    $priavatar = $folder . $filename;
                    $upload->moveTo($uploaddir . $priavatar);

                    $priavatar = get_client_static_dir() . $priavatar;
                    $refObj  = new \ReflectionObject($upload);
                    $refProp1 = $refObj->getProperty('_key');
                    $refProp1->setAccessible(TRUE);
                    $fieldName = $refProp1->getValue($upload);  
                    if (empty($listimage[$fieldName]))
                        $listimage[$fieldName] = $priavatar;
                    else if (is_array($listimage[$fieldName]))
                        $listimage[$fieldName][] = $priavatar; 
                    else if (is_string($listimage[$fieldName]))
                        $listimage[$fieldName] = array($listimage[$fieldName], $priavatar); 
                }
            }
        }
        if ($returnarray == true) return $listimage;
        else return $priavatar;

    }

    public function getLanguage()
    {
        $lang = new viVN();
        return $lang;
    }

    public function checkpermission($key)
    {
        $module = new Module();
        if ($module->is_accept_permission($key) == 0) {
            $uinfo = $this->session->get('uinfo');
            if (!count($uinfo)) {
                $this->response->redirect("security/login");
                return 0;
            }
            $this->flash->error($this->getLanguage()->permission_denied);
            $this->response->redirect("security/message");
            return 0;
        } else return 1;
    }

    public function getRealPathImage($imageUrl)
    {
        return str_replace("/web/", get_client_static_dir(), $imageUrl);
    }

    public function getShortenPathImage($imageUrl)
    {
        return str_replace(get_client_static_dir(), "/web/", $imageUrl);
    }

    protected function _getMediaLocalpath($mediaUrl) {
        return str_replace("/web/", $this->config->upload->dir, $mediaUrl);
    }

    public static function jsonResponse($response)
    {
        if (!is_array($response)) return;
        header("Content-Type:application/json;charset=utf-8");
        die(json_encode($response));
    }
}
