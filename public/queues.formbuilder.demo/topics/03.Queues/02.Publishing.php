<?php

include __DIR__ . "/../../../../vendor/autoload.php";

use Tutorial\QueueSystem\Notifications\ENotificationsQueueConfig;
use Tutorial\QueueSystem\Notifications\NotificationsQueue;

$numberOfSMS    = 2;
$numberOfEmails = 5;

try {
	
	$notificationQueueObject = new NotificationsQueue();

	for($i = 0;  $i < $numberOfSMS; $i++){
		$smsMessage = [
			'to' => '+4 0767 906 895',
			'message' => 'Hello, time is ' . microtime()
		];
		
		$notificationQueueObject->publish( json_encode($smsMessage), ENotificationsQueueConfig::SMS_NOTIFICATION_ROUTING_KEY );
		
		usleep(10);
	}

	for($i = 0;  $i < $numberOfEmails; $i++){
		$emailMessage = [
			'to' => 'alex@123formbuilder.com',
			'message' => 'Hello, time is ' . microtime()
		];
		
		$notificationQueueObject->publish( json_encode($emailMessage), ENotificationsQueueConfig::EMAIL_NOTIFICATION_ROUTING_KEY );
		
		usleep(10);
	}
	
	$notificationQueueObject->closeChannel();
	
} catch ( \Tutorial\QueueSystem\QueueException $e ) {
	echo 'Something went wrong';
}

