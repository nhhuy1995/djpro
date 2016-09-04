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
        'uploadDir'      => APP_PATH . '/public/media'
    )
));
