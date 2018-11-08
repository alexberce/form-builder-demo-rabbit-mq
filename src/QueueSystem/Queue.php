<?php


namespace Tutorial\QueueSystem;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

abstract class Queue {
	
	/**
	 * @var AMQPStreamConnection
	 */
	protected $connection;
	
	/**
	 * @var \PhpAmqpLib\Channel\AMQPChannel
	 */
	protected $channel;
	
	/**
	 * @var string
	 */
	protected static $connectionHost = 'queues.formbuilder.demo';
	
	/**
	 * @var int
	 */
	protected static $connectionPort = 5672;
	
	/**
	 * @var string
	 */
	protected static $connectionUserName = 'demo';
	
	/**
	 * @var string
	 */
	protected static $connectionPassword = 'demo';
	
	/**
	 * ApplicationQueue constructor.
	 *
	 * @param $virtualHost
	 *
	 * @throws QueueException
	 */
	public function __construct( $virtualHost ) {
		
		if(empty ($virtualHost)){
			throw new QueueException(QueueException::INVALID_VIRTUAL_HOST);
		}
		
		$this->connection = new AMQPStreamConnection(
			self::$connectionHost,
			self::$connectionPort,
			self::$connectionUserName,
			self::$connectionPassword,
			$virtualHost
		);
		
		$this->channel = $this->connection->channel();
	}
	
	/**
	 * @param $exchangeName
	 */
	protected function declareExchange( $exchangeName ){
		$this->channel->exchange_declare(
			$exchangeName,
			'direct',
			false,
			true,
			false
		);
	}
	
	/**
	 * @param       $queueName
	 * @param array $arguments
	 */
	protected function declareQueue( $queueName, $arguments = [] ){
		$this->channel->queue_declare(
			$queueName,
			false,
			true,
			false,
			false,
			false,
			$arguments
		);
	}
	
	/**
	 * @param $queueName
	 * @param $exchangeName
	 * @param $routingKey
	 */
	protected function bindQueue($queueName, $exchangeName, $routingKey){
		$this->channel->queue_bind($queueName, $exchangeName, $routingKey);
	}
	
	/**
	 * @param      $message
	 * @param null $routingKey
	 * @param null $exchange
	 *
	 * @throws QueueException
	 */
	public function publish($message, $routingKey = null, $exchange = null)
	{
		if(empty($routingKey))
			throw new QueueException( QueueException::EMPTY_ROUTING_KEY );
		
		$msg = new AMQPMessage(
			$message,
			array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
		);
		
		$this->channel->basic_publish(
			$msg,
			$exchange,
			$routingKey
		);
	}
	
	/**
	 * @return void
	 */
	public function closeChannel(){
		$this->channel->close();
		$this->connection->close();
	}
	
	/**
	 * @param int $time In seconds
	 * @param     $routingKey
	 *
	 * @param     $exchangeName
	 *
	 * @return array
	 */
	public static function getArgumentsForDelayedQueue($time, $routingKey, $exchangeName){
		return array(
			'x-message-ttl'             => array( 'I', $time * 1000 ),
			'x-dead-letter-exchange'    => array( 'S', $exchangeName ),
			'x-dead-letter-routing-key' => array( 'S', $routingKey ),
		);
	}
}