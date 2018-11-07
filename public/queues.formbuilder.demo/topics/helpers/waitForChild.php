<?php

while (($pid = pcntl_waitpid(0, $status, WNOHANG)) != -1) {
	if ($pid < 1) {
		sleep(1);
		continue;
	}
};