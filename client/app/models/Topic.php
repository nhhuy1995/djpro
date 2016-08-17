<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Topic Settings
 * @package DjCms\Models
 * @author hungln
 * @description Topic Collection in Db
 */
class Topic extends BaseCollection
{
    public function getSource()
    {
        return "topic";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}