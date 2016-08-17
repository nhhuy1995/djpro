<?php
function get_client_static_dir() {
    return "http://dj.pro.vn/web/";
}

$config->upload->dir = "/home/djpro/public_html/public/web/";
$config->upload->mediaurl = "http://dj.pro.vn/";
define('HAS_RABBIT_MQ', 1);