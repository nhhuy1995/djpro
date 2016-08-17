<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Media
 * @package DjCms\Models
 * @author huynh
 * @description Media Collection in Db
 */
class Media extends BaseCollection {
    public function getSource() {
        return "media";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }
}