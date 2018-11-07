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

/**
 * https://linux.die.net/man/2/fork
 * Fork() will fail and no child process will be created if:
 *
 * [EAGAIN]
 *  - The system-imposed limit on the total number of pro-
 * cesses under execution would be exceeded. This limit
 * is configuration-dependent.
 *
 * - The system-imposed limit MAXUPRC (<sys/param.h>) on the
 * total number of processes under execution by a single
 * user would be exceeded.
 *
 * - It was not possible to create a new process because the caller's RLIMIT_NPROC resource limit was encountered.
 * To exceed this limit, the process must have either the CAP_SYS_ADMIN or the CAP_SYS_RESOURCE capability.
 *
 * [ENOMEM]
 * - fork() failed to allocate the necessary kernel structures because memory is tight.
 *
 * [ENOSYS]
 * - fork() is not supported on this platform (for example, hardware without a Memory-Management Unit).
 */