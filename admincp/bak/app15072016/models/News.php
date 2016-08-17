<?php
namespace DjCms\Models;

class News extends BaseCollection {
    public function getSource() {
        return "news";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }

}