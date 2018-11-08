<?php
declare(ticks=1);

function signalHandler($signalNumber){
	echo "\n\n [Received signal $signalNumber]\n\n";
}

pcntl_signal(SIGINT, "signalHandler");

while(1){
	$secondsTotal = $secondsLeft = rand(2, 5);
	echo "Doing something, it's taking $secondsTotal seconds... \n";
	
	while ($secondsLeft--){
		echo "Job progress [$secondsLeft of $secondsTotal]... \r\n";
		sleep(1);
	}
}

echo "\r\nStop\r\n";

