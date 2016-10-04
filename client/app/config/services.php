<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Mvc\Dispatcher;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Redis as BackendRedis;
use \Phalcon\Mvc\Dispatcher as PhDispatcher;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();
$di->set('router', function () {
    return require __DIR__ . '/routes.php';
});
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
                'compiledSeparator' => '_',
                'stat' => true,
                'compileAlways' => true
            ));

            return $volt;
        },
        // '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
});
$di->set('collectionManager', function () {
    return new Phalcon\Mvc\Collection\Manager();
}, true);


$di->set('mongo', function () use ($config) {
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
$di->set('cookies', function () {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
}, true);
/**
 *  Register dispatcher for use hooked method
 */
$di->set(
    'dispatcher',
    function() use ($di) {

        $evManager = $di->getShared('eventsManager');

        $evManager->attach("dispatch", function ($event, $dispatcher, $exception) {
            //controller or action doesn't exist
            if ($event->getType() == 'beforeException') {
                switch ($exception->getCode()) {
                    case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(array(
                            'controller' => 'notfound',
                            'action' => 'show404',
                        ));

                        return false;
                }
            }
        });

        $evManager->attach(
            "dispatch:beforeDispatch",
            function($event, $dispatcher, $exception) {
                $matchedRoute = \Phalcon\DI::getDefault()->get('router')->getMatchedRoute();
                if (!$matchedRoute && $dispatcher->getControllerName() != 'notfound') {
                    $dispatcher->forward(array(
                        'controller' => 'notfound',
                        'action' => 'show404',
                    ));
                }
            }
        );

        $dispatcher = new PhDispatcher();
        $dispatcher->setEventsManager($evManager);
        $dispatcher->setDefaultNamespace('DjClient\Controller');
        return $dispatcher;
    },
    true
);
// $di->set('dispatcher', function () {
//     $dispatcher = new Dispatcher();
//     $dispatcher->setDefaultNamespace('DjClient\Controller');
//     return $dispatcher;
// });
//Set the models cache service
$di->setShared('redisConnect', function () use ($config) {
    //Cache data for one day by default
    $frontCache = new FrontendData(array(
        "lifetime" => 86400
    ));
    $redis = new Redis();
    $redis->connect(
        $config->redis->host,
        $config->redis->port
    );
    return $redis;
});
