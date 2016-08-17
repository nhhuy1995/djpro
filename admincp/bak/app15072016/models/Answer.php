<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Answer
 * @package DjCms\Models
 * @author huynh
 * @description answer Collection in Db
 */
class Answer extends BaseCollection {
    public function getSource() {
        return "answer";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }
}