<?php

use Tutorial\QueueSystem\Notifications\ENotificationsQueueConfig;
use Tutorial\QueueSystem\Notifications\NotificationsQueue;

/** @var int $childId */

try {
	$notificationQueueObject = new NotificationsQueue();

	$numberOfEmails = 10;
	
	for($i = 0; $i < $numberOfEmails; $i++){
		$emailMessage = [
			'to' => 'alex@123formbuilder.com',
			'message' => 'Hello, time is ' . microtime()
		];
		
		$notificationQueueObject->publish( json_encode($emailMessage), ENotificationsQueueConfig::EMAIL_NOTIFICATION_ROUTING_KEY );
		
		sleep(1);
	}
	
	$notificationQueueObject->closeChannel();
} catch ( \Tutorial\QueueSystem\QueueException $e ) {
	echo "\n Something went wrong with job [$childId]";
}
