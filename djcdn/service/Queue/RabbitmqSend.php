<?php
/**
 * @author: Namtq
 * @desc: queue rabbitmq
 * @lib: PhpAmqpLib
 */
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

//define('AMQP_DEBUG', true);
class RabbitmqSend
{
    protected $_rabbitConnect;
    protected $_rabbitChannel;
    private $rpc_respone;
    private $rpc_corr_id;
    private $callback_queue;
    
    public function __construct($option = array()) {
        $connection = new AMQPConnection(
                $option['host'], $option['port'],
                $option['username'], $option['password'],$option['vhost']
        );
        $this->_rabbitChannel = $connection->channel();
        $this->_rabbitConnect = $connection;
    }
    
    public function sendMessage($key, $message) {
        if (!$key || !$message) {
            echo 'Key: '.$key.', Message: '.$message.' -- input wrong';
            return false;
        }
        if (!is_array($message)) $message = array($message);
        if (is_array($key)) $key = $key['key'];
        try {
            $channel = $this->_rabbitChannel;
            $channel->queue_declare($key, false, false, false, false);// return queue name
            $msg = new AMQPMessage( 
                json_encode($message) ,
                array('delivery_mode' => 2)
            ); # make message persistent;
            $channel->basic_publish($msg, '', $key);
            $result = true;
        } catch (Exception $e) {
            die("Error RabbitmqSend message: " + $e->getMessage());
        }
        return $result ? $result : false;
    }
    
    public function callRpc($key, $message) {
        $result = false;
        if (!$key || !$message) {
            echo 'Key: '.$key.', Message: '.$message.' -- input wrong';
            return false;
        }
        $this->rpc_respone = Null;
        $this->rpc_corr_id = time().uniqid();
        if (!is_array($message)) 
            $message = array($message);
        // fix rpc to callback
        $message['rpc'] = 1;
        
        if (is_array($key)) 
            $key =  $key['key'] ;
        
        try {
            $channel = $this->_rabbitChannel;
            list($this->callback_queue, ,) = $channel->queue_declare("", false, false, true, false);
            if (!$this->callback_queue) {
                return false; 
            } 
            $channel->basic_consume($this->callback_queue, '', false, false, false, false,array($this, 'rpc_resopone'));
    
            $msg = new AMQPMessage(
                (string) json_encode($message),
                array('correlation_id' => $this->rpc_corr_id,
                      'reply_to' => $this->callback_queue)
                );
            $channel->basic_publish($msg, '', $key);
            while(!$this->rpc_respone) {
                 $channel->wait(null,false,30); // timeout 30s
            }
            return $this->rpc_respone;
            
        }
        catch (Exception $e)
        {
            var_dump($e);
            die("Error RabbitmqSend message");
        }
        return $result;
    }
    
    public function getRpcResponse ($rep) {
        if($rep->get('correlation_id') == $this->rpc_corr_id) {
            return $this->rpc_respone = $rep->body;
        }
    }
    
    public function __destruct() {
        $this->_rabbitChannel->close();
        $this->_rabbitConnect->close();
    }

    public function isConnected() {
        return $this->_rabbitConnect->isConnected();
    }
}