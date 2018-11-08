<?php

include __DIR__ . "/../../../../vendor/autoload.php";

/** @var int $childId*/
/** @var bool $isChild*/

$jobs = [
	'jobs/publish/publishSms.php',
	'jobs/publish/publishEmail.php',
];

$numberOfProcesses = 2;
include "../helpers/processForker.php";

if($isChild){
	
	if($jobs[$childId-1]){
		echo "\n STARTING JOB [$childId]";
		include $jobs[$childId-1];
	}
	
	echo "\n JOB DONE CHILD [$childId]";
	
} else {
	
	include "../helpers/waitForChild.php";
	echo "\n ALL JOBS DONE\n";
	
}