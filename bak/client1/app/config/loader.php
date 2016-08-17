<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->serviceDir
    )
);


/**
 *  Regester for some main namespace
 */
$loader->registerNamespaces(array(
    'DjClient\Controller' => $config->application->controllersDir,
    'DjClient\Models' => $config->application->modelsDir,
    'DjClient\Library' => $config->application->libraryDir,
    'DjClient\Lang' => $config->application->langDir,
    'DjClient\Services' => $config->application->serviceDir

));

$loader->register();

