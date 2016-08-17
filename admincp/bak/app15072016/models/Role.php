<?php
namespace DjCms\Models;

class Role extends BaseCollection {
    public function getSource() {
        return "role";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }

}