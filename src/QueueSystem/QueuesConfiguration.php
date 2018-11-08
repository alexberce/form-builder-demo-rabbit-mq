<?php


namespace Tutorial\QueueSystem;


use Tutorial\QueueSystem\Notifications\ENotificationsQueueConfig;
use Tutorial\QueueSystem\Notifications\NotificationsQueue;

class QueuesConfiguration {
	
	/**
	 * @throws QueueException
	 */
	public static function init() {
		foreach(ENotificationsQueueConfig::$allVirtualHosts as $virtualHost){
			(new NotificationsQueue($virtualHost))->initQueue();
		}
	}
}