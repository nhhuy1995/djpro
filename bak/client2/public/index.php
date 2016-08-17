<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
define('APP_PATH', realpath('..'));

try {
    /**
     * Include vendor
     */
    require_once APP_PATH . '/vendor/autoload.php';

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    $developConfigFilePath = APP_PATH . "/app/config/develop.config.php";
    if (file_exists($developConfigFilePath)) {
        $config->merge(include $developConfigFilePath);
    };


    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
