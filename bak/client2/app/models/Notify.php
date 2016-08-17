<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Notify
 * @package DjClient\Models
 * @author huynh
 * @description Notify Collection in Db
 */
class Notify extends BaseCollection
{
    public function getSource()
    {
        return "notify";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getNotifyByType($uinfo, $id, $type)
    {
        return Notify::findFirst(array("conditions" => array('userid' => $uinfo, 'atid' => $id, 'type' => $type,)));
    }

    /*
     * @param $id is id comment
     *
     */
    public static function getNotifyByIdCM($id, $userid)
    {
        return Notify::findFirst(array('conditions' => array('idcomment' => $id, 'userid' => $userid)));
    }


}