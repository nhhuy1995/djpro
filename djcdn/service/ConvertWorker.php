<?php
ini_set('display_errors', false);
//error_log(E_WARNING);

$configDir = __DIR__."/../config";

$config = include $configDir . "/config.php";

if (file_exists($configDir . "/development.config.php"))
    include $configDir . "/development.config.php";

include __DIR__ . "/../../vendor/autoload.php";
//include __DIR__ . "/../library/Queue/RabbitmqReceive.php";

$loader = new Phalcon\Loader();
$loader->registerNamespaces(array(
   "DjCms\\Library" => __DIR__ . "/../library"
));
$loader->register();

function rabbit_worker_callback($params) {
    try {
        global $config;


        $message = json_decode($params->body);

        if (strlen($message->mediaurl)) {
            echo "---Start convert in ". time('d-m-Y H:i:s') . "--- \n";
            $mediaUrl = escapeshellarg($message->mediaurl);
            $mediaNewName = escapeshellarg($message->medianame);
            $bitrate = $message->bitrate;
            $shellCmd = "ffmpeg -loglevel panic -i " . $mediaUrl . " -ab " . $bitrate . " " . $mediaNewName;
            system($shellCmd);
            echo "$mediaUrl \n TO: $mediaNewName  \n with bitrate: $bitrate \n";
            echo "-- finish convert -------------------------------- \n\n";

            $connectionString = "mongodb://";
            $connectionString .= $config->database->username;
            $connectionString .= ":" . $config->database->password;
            $connectionString .= "@" . $config->database->host;
            $connectionString .= ":" . $config->database->port;

            $connection = new MongoClient($connectionString);
            $dbConnect = $connection->djpro;

            $mediaCursor = $dbConnect->media;
            $mediaCursor->update(
                array("_id" => $message->atid),
                array(
                    '$set' => array(
                        "direct_media_url_$bitrate" => trim($message->medianame, "'")
                    )
                )
            );
        }

        $params->delivery_info['channel']->basic_ack($params->delivery_info['delivery_tag']);

    } catch (Exception $e) {
        var_dump($e);
    }

};


$rabbitWorker = new \DjCms\Library\Queue\RabbitmqReceive(
    array(
        "host" => "127.0.0.1",
        "port" => "5672",
        "username" => "guest",
        "password" => "guest",
        "vhost" => "/"
    )
);
$rabbitWorker->processQueue(array(
    array(
        "key" => "convert_audio_quality",
        "callback" => "rabbit_worker_callback",
    )
));
