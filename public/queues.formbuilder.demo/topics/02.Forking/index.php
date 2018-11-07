<?php

$ticks = 2;
$i = 0;

function myTickHandler(){
	echo "tick | ";
}
register_tick_function('myTickHandler');

global $shouldStop;
$shouldStop = false;

function signalHandler(){
	global $shouldStop;
	
	$shouldStop = true;
}

pcntl_signal(SIGINT, "signalHandler");

declare(ticks=1);

while($shouldStop === false){
	echo "\r\nFirst while $i\r\n";
	$i++;
	sleep(1);
	
	$j = 0;
	while($j++ <= 2){
		echo "\r\nSecond while $j\r\n" ;
		sleep(1);
	}
}

echo "\r\nStop\r\n";

