<?php

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
        'appid' => '1769764786632166',
        'appsecret' => 'bf318286b4e458aa89e3e30cf4678603',
    ),
    'google' => array(
        'clientid' => '231391428533-a67s2i3r7dksi69v0cr20ujkjm5t0dgb.apps.googleusercontent.com',
        'clientsecret' => 'yjb5GqEYYKt6tHsw-acJd630',
    ),

));
