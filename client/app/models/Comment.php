<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use Phalcon\Mvc\Collection;

/**
 * Class Comment
 * @package DjCms\Models
 * @author huynh
 * @description Comment Collection in Db
 */
class Comment extends BaseCollection
{
    public function getSource()
    {
        return "comment";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getListCommentChildren($id, $uinfo, $username = null)
    {
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('parent_id' => $id),
            "limit" => 4,
            'sort' => array('datecreate' => 1),
        ));  //list comment children
        foreach ($listcomment as $key => $item) {
            $id = $item['_id'];
            $uid = $item['user_id'];
            $content = $item['content'];
            $o = Users::getUserById($uid);// get user by userid
            $listcomment[$key]['priavatar'] = $o->priavatar;
            $listcomment[$key]['link'] = $o->link;
            if ($username != null) $listcomment[$key]['name_parent'] = $username;
            $listcomment[$key]['is_comment_of_my'] = ($uid == $uinfo['_id']) ? 1 : 0;
            $listcomment[$key]['username'] = Users::getUserInfo($uid);
            $listcomment[$key]['content'] = Helper::CheckStringExpletives($content);
            //check like comment
            $checklike_child = Notify::getNotifyByIdCM($item['_id'], $uinfo['_id']);
            $listcomment[$key]['checklike'] = isset($checklike_child->_id) ? 1 : 0;
        }
        return $listcomment;
    }
}