<?php

$numberOfProcesses = 2;

for ($i = 0; $i <= $numberOfProcesses; $i++) {
	$pid = pcntl_fork();
	
	switch ($pid) {
		case -1: //FAIL
			die('Fork failed');
			break;
		case 0: //CHILD
			print "FORK: Child #{$i} \n";
			break;
		default: //PARENT
			print "FORK: Parent\n";
			pcntl_waitpid($pid, $status);
	}
}