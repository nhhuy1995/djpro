<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Answer
 * @package DjCms\Models
 * @author huynh
 * @description Answer Collection in Db
 */
class Answer extends BaseCollection
{

    public function getSource()
    {
        return "answer";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

}