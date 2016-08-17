<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));
define('DOMAIN', 'http://dj.pro.vn');
//ini_set('display_errors', true);
//error_reporting(E_ALL);
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
        'modelsDir' => APP_PATH . '/app/models/',
        'migrationsDir' => APP_PATH . '/app/migrations/',
        'viewsDir' => APP_PATH . '/app/views/web/',
        'pluginsDir' => APP_PATH . '/app/plugins/',
        'libraryDir' => APP_PATH . '/app/library/',
        'langDir' => APP_PATH . '/app/lang/',
        'cacheDir' => APP_PATH . '/app/cache/',
        'serviceDir' => APP_PATH . '/app/services/',
        'baseUri' => '/',
        'site' => 'dj.pro.vn',
        'baseFrontendUri' => 'http://dj.pro.vn'
    ),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => '6379'
    ),
    'facebook' => array(
        'appid' => '1652030615071595',
        'appsecret' => 'ccecc02b5e4f2c853278e0b7d44e2997',
    ),
    'google' => array(
        'clientid' => '687423976237-42aimfj21hq6evg01s8b6ntr6n8so1dd.apps.googleusercontent.com',
        'clientsecret' => 'sdTudbC78ORXKGd0ovCKtzXY',
    ),

));
