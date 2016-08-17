<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Album
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Album extends BaseCollection {
//    protected static $_collect_instance;
    public function getSource() {
        return "album";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }
}