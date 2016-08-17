<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->langDir,
		$config->application->libraryDir
    )
);

/**
 *  Regester for some main namespace
 */
$loader->registerNamespaces(array(
    'DjCms\Controller' => $config->application->controllersDir,
    'DjCms\Models' => $config->application->modelsDir,
    'DjCms\Library' => $config->application->libraryDir,
    'DjCms\Lang' => $config->application->langDir,
    'DjCms\Service' => $config->application->serviceDir

));

$loader->register();
