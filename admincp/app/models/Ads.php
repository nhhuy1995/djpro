<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Ads
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Ads extends BaseCollection {
//    protected static $_collect_instance;
    public function getSource() {
        return "ads";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }
}