<?php

use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../config/config.php";

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);
    $app->config = $config;

    /**
     * Include some utility function 
     * Inject to app instance
     */
    include APP_PATH . '/config/utility.php';

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle();

} catch (\Exception $e) {
    echo $e->getMessage();
}
