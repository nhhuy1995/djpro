<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */
use Phalcon\Mvc\Dispatcher;
use DjCms\Library\Acl;
use DjCms\Library\Auth;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Set Flash session
 */
$di->set('flash', function() {
    $flash = new \Phalcon\Flash\Session([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
    ]);

    return $flash;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
});
$di->set('collectionManager', function(){
    return new Phalcon\Mvc\Collection\Manager();
}, true);
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

$di->set('mongo', function() use ($config) {
    $host = $config->database->host;
    $user = $config->database->username;
    $pass = $config->database->password;
    $port = $config->database->port;
    $dbname = $config->database->dbname;
    $mongo = new MongoClient("mongodb://$user:$pass@$host:$port");
    return $mongo->selectDB("$dbname");
}, true);

$di->set('config', function () use ($config) {
    return $config;
});

/**
 *  Register dispatcher for use hooked method
 */
$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('DjCms\Controller');
    return $dispatcher;
});