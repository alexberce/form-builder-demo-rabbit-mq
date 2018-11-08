<?php


namespace Tutorial\QueueSystem\Notifications;


class ENotificationsQueueConfig {
	
	const EXCHANGE_NAME = 'NOTIFICATIONS_EXCHANGE';
	
	const EMAIL_NOTIFICATION_ROUTING_KEY = 'EMAIL_NOTIFICATIONS';
	const SMS_NOTIFICATION_ROUTING_KEY  = 'SMS_NOTIFICATIONS';
	
	CONST EMAIL_NOTIFICATION_QUEUE_NAME = 'notifications_email_queue';
	CONST SMS_NOTIFICATION_QUEUE_NAME = 'notifications_sms_queue';
	
	const VIRTUAL_HOST_LIVE_NAME = 'live';
	const VIRTUAL_HOST_DEVELOPMENT_NAME = 'development';
	
	/**
	 * @var array
	 */
	public static $allRoutingKeys = [
		self::EMAIL_NOTIFICATION_ROUTING_KEY,
		self::SMS_NOTIFICATION_ROUTING_KEY,
	];
	
	/**
	 * @var array
	 */
	public static $allQueues = [
		self::EMAIL_NOTIFICATION_QUEUE_NAME,
		self::SMS_NOTIFICATION_QUEUE_NAME,
	];
	
	/**
	 * @var array
	 */
	public static $queueBindings = [
		self::EMAIL_NOTIFICATION_ROUTING_KEY => self::EMAIL_NOTIFICATION_QUEUE_NAME,
		self::SMS_NOTIFICATION_ROUTING_KEY => self::SMS_NOTIFICATION_QUEUE_NAME,
	];
	
	/**
	 * @var array
	 */
	public static $allVirtualHosts = [
		self::VIRTUAL_HOST_LIVE_NAME,
		self::VIRTUAL_HOST_DEVELOPMENT_NAME,
	];
	
	/**
	 * @return array
	 */
	public static function getAllConfig(){
		return [
			'virtualHosts' => self::$allVirtualHosts,
			'queues' => self::$allQueues,
			'routingKeys' => self::$allRoutingKeys,
			'bindings' => self::$queueBindings,
		];
	}
}