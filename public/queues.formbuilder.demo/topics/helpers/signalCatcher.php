<?php

global $shouldStop;
$shouldStop = false;

function signalHandler($signalNumber){
//	$pid = posix_getpid();
//	echo "\r\n Received SIGNAL $signalNumber, I'm PID: $pid \r\n";
	
	global $shouldStop;
	$shouldStop = true;
}

pcntl_signal(SIGINT, "signalHandler");

pcntl_signal(SIGQUIT, "signalHandler");
pcntl_signal(SIGTERM, "signalHandler");