<?php

function signalHandler($signalNumber){
	echo "Received signal $signalNumber";
}

/**
 * https://en.wikipedia.org/wiki/Signal_(IPC)
 * SIGINT | SIGTERM: terminate a process; it can be blocked, handled, and ignored unlike SIGKILL.
 * SIGKILL: immediately terminate a process
 */

pcntl_signal(SIGINT, "signalHandler");
//pcntl_signal(SIGKILL, "signalHandler"); //cannot be caught or blocked
pcntl_signal(SIGTERM, "signalHandler");
pcntl_signal(SIGQUIT, "signalHandler");

$secondsToRun = 10;
while($secondsToRun--){
	//Do nothing
	
	echo "Doing something... \n";
	sleep(1);
}