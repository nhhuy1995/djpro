<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Topic
 * @package DjCms\Models
 * @author hungln
 * @description Topic Collection in Db
 */
class Topic extends BaseCollection
{
//    protected static $_collect_instance;
    public function getSource()
    {
        return "topic";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}