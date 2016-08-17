<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Users
 * @package DjCms\Models
 * @author hungln
 * @description Users Collection in Db
 */
class Users extends BaseCollection
{
    public function getSource()
    {
        return "user";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getUserInfo($userid)
    {
        $userObj = Users::findById($userid);
        return $userObj->username;
    }

    public static function getUserById($userid)
    {
        $data = Users::findById($userid);
        $data->link = Makelink::link_view_member($data->username, $data->_id);
        $roleid = $data->role;
        if (isset($roleid) || !empty($roleid)) { // get name role
            $roleinfo = Role::findAndReturnArray(array('condition' => array('_id' => array('$in' => $roleid))));
            $data->namerole = $roleinfo[0]['name'];
            $data->is_role = 1;
        } else {
            $data->namerole = 'Thành viên';
            $data->is_role = 2;
        }
        $avatar = $data->priavatar;
        if (empty($avatar) || !isset($avatar)) $data->priavatar = '/web/images/avatar_default_user.png';
        return $data;
    }
}