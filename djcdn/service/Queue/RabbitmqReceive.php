<?php
/**
 * @author: Namtq
 * @desc: queue rabitmq
 * @lib: PhpAmqpLib
 */
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
//define('AMQP_DEBUG', true);
class RabbitmqReceive
{
    protected static $_rabbitConnect;
    protected static $_rabbitChannel;
    protected $maxConsumers = 1;
    
    public function __construct($option = array()) {
        $connection = new AMQPConnection(
                $option['host'], $option['port'],
                $option['username'], $option['password'],$option['vhost']
        );
        self::$_rabbitChannel = $connection->channel();
        self::$_rabbitConnect = $connection;
    }
    
    public function processQueue($keys) {
        if (!is_array($keys)) {
            $keys = array($keys);
        }
        $channel = self::$_rabbitChannel;

        foreach ($keys as $key) {
            $this->message($key);
        }
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        while(count($channel->callbacks)) {
            $channel->wait();
        }
    }
    
    /**
     * receive key
     * @param: array('key' => 'xxx', 'class' => classname, 'function' => function name)
     * @author: namtq
     */
    public function message($key) {
        $channel = self::$_rabbitChannel;
        list(,,$consumerCount) = $channel->queue_declare($key['key'], false, false, false, false);
        if ($consumerCount > $this->maxConsumers) {
            return;
        }
        $callback = ($key['callback'])  ? $key['callback'] : 'rabbit_worker_callback';
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($key['key'], '', false, false, false, false, $callback);
    }
    
    public function rpc($req,$reply) {
        if (is_array($reply)) {
            $reply = json_encode($reply);
        }
        echo " [.] RPC Start Here - ".$req->get('reply_to')." \n";
        $msg = new AMQPMessage(
            (string) $reply,
            array('correlation_id' => $req->get('correlation_id'))
        );
        $req->delivery_info['channel']->basic_publish(
            $msg, '', $req->get('reply_to'));
    }
    
    public function __destruct() {
        self::$_rabbitChannel->close();
        self::$_rabbitConnect->close();
    }

    public function isConnected() {
        return self::$_rabbitConnect->isConnected();
    }
    
}