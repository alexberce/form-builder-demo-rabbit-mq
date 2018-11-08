<?php

use Tutorial\QueueSystem\Notifications\ENotificationsQueueConfig;
use Tutorial\QueueSystem\Notifications\NotificationsQueue;

/** @var int $childId */

try {
	$notificationQueueObject = new NotificationsQueue();
	$numberOfSMS = 5;
	
	for($i = 0; $i < $numberOfSMS; $i++){
		$smsMessage = [
			'to' => '+4 0767 906 895',
			'message' => 'Hello, time is ' . microtime()
		];
		
		$notificationQueueObject->publish( json_encode($smsMessage), ENotificationsQueueConfig::SMS_NOTIFICATION_ROUTING_KEY );
		
		sleep(1);
	}
	
	$notificationQueueObject->closeChannel();
} catch ( \Tutorial\QueueSystem\QueueException $e ) {
	echo "\n Something went wrong with job [$childId]";
}