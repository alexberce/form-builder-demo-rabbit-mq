<?php

if(isset($numberOfProcesses) && $numberOfProcesses > 0)
	for ($i = 1; $i <= $numberOfProcesses; $i++) {
		
		$pid = pcntl_fork();
		
		switch ($pid) {
			case -1: //FAIL
				die('Fork failed');
				break;
			case 0: //CHILD
				$isChild = true;
				$childId = $i;
				
				include "processName.php";
				break 2;
			default: //PARENT
				$isChild = false;
				break;
		}
	}