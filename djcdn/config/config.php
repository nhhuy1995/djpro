<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(

    'database' => array(
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'test',
        'charset'    => 'utf8',
    ),

    'application' => array(
        'domain'         => 'http://s1.download.stream.djscdn.com/',
        'uploadMediaUrl' => 'http://s1.download.stream.djscdn.com/media',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'serviceDir'     => APP_PATH . '/service/',
        'baseUri'        => '/',
        'uploadDir'      => APP_PATH . '/public/media',
        'uploadImageDir' => APP_PATH . '/public/media/picture',
        'imageType'      => array('user', 'artist', 'video', 'playlist', 'album', 'topic')
    ),

    'web_database' => array(
        'adapter' => 'MongoDB',
        'host' => '103.9.156.125',
        'port' => 27017,
        'username' => 'root',
        'password' => '123456$',
        'dbname' => 'djpro',
        'charset' => 'utf8',
    )
));
