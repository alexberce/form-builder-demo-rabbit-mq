<?php
/** @var int $childId */

$numberOfProcesses = 5;
$variable = 10;
$isChild = null;

include "../helpers/processForker.php";

if ($isChild) {
	echo "FORK: Child\n";
	
	if (php_sapi_name() == "cli") {
		cli_set_process_title("ForkingTutorial: $childId out of $numberOfProcesses");
	}
	
	sleep(rand(5, 15));
//	echo "\r\nJOB DONE - WORKER $childId!\r\n";
	
} else {
	echo "FORK: Parent\n";
	while ($pid = pcntl_waitpid(0, $status, WNOHANG) != -1) {
		if ($pid < 1) {
			sleep(1);
			continue;
		}
	};
	
//	echo "\r\nJOB DONE - ALL WORKERS!\r\n";
}

//echo "\r\nJOB DONE !\r\n";