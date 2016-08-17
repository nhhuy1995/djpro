<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Feedback
 * @package DjCms\Models
 * @author huynh
 * @description Tags Collection in Db
 */
class Feedback extends BaseCollection
{
    public function getSource()
    {
        return "error_music";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}