<?php
ini_set('display_errors', false);
//error_log(E_WARNING);

$configDir = __DIR__."/../config";

$config = include $configDir . "/config.php";

if (file_exists($configDir . "/development.config.php"))
    include $configDir . "/development.config.php";

$loader = new Phalcon\Loader();
$loader->registerNamespaces(array(
   "DjCms\\Library" => __DIR__ . "/../library"
));
$loader->register();

$connectionString = "mongodb://";
$connectionString .= $config->database->username;
$connectionString .= ":" . $config->database->password;
$connectionString .= "@" . $config->database->host;
$connectionString .= ":" . $config->database->port;

$connection = new MongoClient($connectionString);
$dbConnect = $connection->djpro;

$limitTime = time() - 60;

$artistCusor = $dbConnect->artist;
$artistCusor->remove(
	array(
		'status' => 2,
		'datecreate' => array('$lte' => $limitTime),
	),
    array(
    	'justOne' => FALSE
	)
);


$mediaCusor = $dbConnect->media;
$mediaCusor->remove(
	array(
		'status' => 2,
		'datecreate' => array('$lte' => $limitTime),
	),
    array(
    	'justOne' => FALSE
	)
);

$mediaRequireCusor = $dbConnect->mediarequire;
$mediaRequireCusor->remove(
	array(
		'status' => 2,
		'datecreate' => array('$lte' => $limitTime)
	),
    array(
    	'justOne' => FALSE
	)
);

$albumCusor = $dbConnect->album;
$albumCusor->remove(
	array(
		'status' => 2,
		'datecreate' => array('$lte' => $limitTime)
	),
    array(
    	'justOne' => FALSE
	)
);

$tagCusor = $dbConnect->tag;
$tagCusor->remove(
	array(
		'status' => 2,
		'datecreate' => array('$lte' => $limitTime)
	),
    array(
    	'justOne' => FALSE
	)
);


