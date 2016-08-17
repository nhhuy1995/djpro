<?php
//ini_set('display_errors', true);
//error_reporting(E_ALL);
defined('APP_PATH') || define('APP_PATH', realpath('.'));
define('DOMAIN', 'http://dj.pro.vn');
//session_save_path(getcwd()."/session");
function get_host()
{
    $protocol = explode("/", $_SERVER['SERVER_PROTOCOL']);
    return strtolower(array_shift($protocol)) . "://" . $_SERVER['HTTP_HOST'] . '/';
}
return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'MongoDB',
        'host' => '127.0.0.1',
        'port' => 27017,
        'username' => 'root',
        'password' => '123456$',
        'dbname' => 'djpro',
        'charset' => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'langDir'     => APP_PATH . '/app/lang/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'serviceDir'     => APP_PATH . '/app/service/',
        'baseUri'        => '/',
        'baseFrontendUri' => 'http://dj.pro.vn'
    ),
    'upload' => array(
        "dir" => "",
        "mediaurl" => get_host(),
        "extension" => array("image/jpeg", "image/png", "image/gif", "image/jpg"),
    )
));
