<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Users
 * @package DjCms\Models
 * @author hungln
 * @description Users Collection in Db
 */
class Users extends BaseCollection {
    public function getSource() {
        return "user";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }
}