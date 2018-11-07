<?php
/** @var int $childId */

declare(ticks=1);

$numberOfProcesses = 2;
$variable = 10;
$isChild = null;

include "../helpers/signalCatcher.php";
include "../helpers/processForker.php";

if ($isChild) {
	while(1 && !$shouldStop){
		include 'processes/job.php';
	}
	
	echo "\r\nJOB DONE - WORKER $childId!\r\n";
	
} else {
	include "../helpers/waitForChild.php";
	
	echo "\r\nJOB DONE - ALL WORKERS!\r\n";
}