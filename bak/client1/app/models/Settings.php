<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Settings
 * @package DjCms\Models
 * @author hungln
 * @description Settings Collection in Db
 */
class Settings extends BaseCollection
{
    public function getSource()
    {
        return "settings";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getElementByKey($type)
    {
        $cursor = Settings::findAndReturnArray(array('condition' => array('key' => $type)));
        foreach ($cursor as $item) $listdata[] = $item['value'];
        return $listdata[0];
    }
}