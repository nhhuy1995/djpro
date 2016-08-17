<?php
namespace DjClient\Models;

use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;
use DjClient\Library\Helper;

/**
 * Class Tags
 * @package DjCms\Models
 * @author huynh
 * @description Tags Collection in Db
 */
class Tags extends BaseCollection
{


    public function getSource()
    {
        return "tag";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getListTagsByID($type,$listid)
    {
        $listags = Tags::findAndReturnArray(array('condition' => array('_id' => array('$in' => $listid))));
        foreach ($listags as $key => $val) {
            $listags[$key]['link'] = Makelink::link_view_tags_index($val['name'], $val['_id']);
        }
        $listags = Helper::resortarray($listags, $listid, '_id');
        return $listags;
    }
}