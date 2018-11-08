<?php


namespace Tutorial\QueueSystem\Notifications;


use Tutorial\QueueSystem\Queue;
use Tutorial\QueueSystem\QueueException;

class NotificationsQueue extends Queue
{
    /**
     * @var string
     */
    protected $exchangeName = ENotificationsQueueConfig::EXCHANGE_NAME;
	
	/**
	 * MessageAppQueue constructor.
	 *
	 * @param null $virtualHost
	 *
	 * @throws QueueException
	 */
    public function __construct($virtualHost = null)
    {
    	if($virtualHost === null){
		    $virtualHost = ENotificationsQueueConfig::VIRTUAL_HOST_LIVE_NAME;
	    }
	    
        parent::__construct($virtualHost);
    }
	
	/**
	 * @param      $message
	 * @param null $routingKey
	 *
	 * @throws QueueException
	 */
    public function publish( $message, $routingKey = null) {
	    parent::publish( $message, $routingKey, ENotificationsQueueConfig::EXCHANGE_NAME);
    }
    
    public function initQueue(){
	    $this->declareExchange(ENotificationsQueueConfig::EXCHANGE_NAME);
	
	    $this->declareQueue( ENotificationsQueueConfig::EMAIL_NOTIFICATION_QUEUE_NAME );
	    $this->declareQueue( ENotificationsQueueConfig::SMS_NOTIFICATION_QUEUE_NAME );
	    
	    $this->bindQueue(
	    	ENotificationsQueueConfig::EMAIL_NOTIFICATION_QUEUE_NAME,
		    ENotificationsQueueConfig::EXCHANGE_NAME,
		    ENotificationsQueueConfig::EMAIL_NOTIFICATION_ROUTING_KEY
	    );
	
	    $this->bindQueue(
		    ENotificationsQueueConfig::SMS_NOTIFICATION_QUEUE_NAME,
		    ENotificationsQueueConfig::EXCHANGE_NAME,
		    ENotificationsQueueConfig::SMS_NOTIFICATION_ROUTING_KEY
	    );
    }
}