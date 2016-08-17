<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Media
 * @package DjCms\Models
 * @author huynh
 * @description Media Collection in Db
 */
class Setting extends BaseCollection {
    public function getSource() {
        return "settings";
    }
}