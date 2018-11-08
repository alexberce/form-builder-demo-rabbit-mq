<?php

include __DIR__ . "/../../../../vendor/autoload.php";

/** @var int $childId */

declare(ticks=1);

use Tutorial\QueueSystem\Notifications\ENotificationsQueueConfig;
use Tutorial\QueueSystem\Notifications\NotificationsQueueWorker;

include "../helpers/signalCatcher.php";

$numberOfProcesses = 2;
include "../helpers/processForker.php";

if($isChild){
	
	try {
		$queueName = $childId === 1
			? ENotificationsQueueConfig::EMAIL_NOTIFICATION_QUEUE_NAME
			: ENotificationsQueueConfig::SMS_NOTIFICATION_QUEUE_NAME;
		
		$worker = new NotificationsQueueWorker( ENotificationsQueueConfig::VIRTUAL_HOST_LIVE_NAME );
		$worker->withWorkerId($childId);
		$worker->consume($queueName);
	} catch ( \Tutorial\QueueSystem\QueueException $e ) {}
	
	echo "\nJOB DONE WORKER [$childId]\n";
	
} else {
	
	include "../helpers/waitForChild.php";
	echo "\nJOB DONE ALL WORKERS\n";
	
}