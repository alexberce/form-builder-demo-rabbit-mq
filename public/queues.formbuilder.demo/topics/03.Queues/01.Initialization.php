<?php

include __DIR__ . "/../../../../vendor/autoload.php";

try {
	( new \Tutorial\QueueSystem\QueuesConfiguration() )->init();
} catch ( \Tutorial\QueueSystem\QueueException $e ) {
	print_r($e);
}