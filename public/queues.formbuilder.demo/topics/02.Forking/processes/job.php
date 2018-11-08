<?php

/** @var int $childId */

if(!isset($childId))
	$childId = null;

$jobName = isset($jobName) ? "[$jobName]" : '';

$secondsTotal = $secondsLeft = rand(4, 15);
echo "[W$childId] Doing my job, it's taking $secondsTotal seconds... \r\n";

while ($secondsLeft--){
	echo "[W$childId] Job progress $jobName [$secondsLeft of $secondsTotal]... \r\n";
	sleep(1);
}