<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Role
 * @package DjCms\Models
 * @author huynh
 * @description Role Collection in Db
 */
class Role extends BaseCollection
{
    public function getSource()
    {
        return "role";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}