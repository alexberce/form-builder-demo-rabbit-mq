<?php

/** @var int $childId */
/** @var int $numberOfProcesses */

if (php_sapi_name() == "cli") {
	cli_set_process_title("ForkingTutorial: $childId out of $numberOfProcesses");
}