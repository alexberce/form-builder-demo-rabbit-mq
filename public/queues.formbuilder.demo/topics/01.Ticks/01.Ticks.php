<?php

/**
 * A tick is an event that occurs for every N low-level tickable statements
 *
 * Not all statements are tickable. Typically, condition expressions and argument expressions are not tickable.
 */

global $ticks;
$ticks = -2;
function myTickHandler(){
	global $ticks;
	if(++$ticks > 0)
		echo "\n\rtick {$ticks}|\n\r";
	
//	for($i = 0; $i < 5; $i++){
//		echo "\n\rTock";
//	}
}
register_tick_function('myTickHandler');
declare(ticks=1);

/**
 * Association
 */

//$maxIterations = 10;

/**
 * Iterations
 */
//for($i = 5; $i < $maxIterations; $i++){
//	echo "\r\nI am an iteration \r\n";
//}

//while($maxIterations-- > 0){
//	echo "\r\nI am an iteration \r\n";
//}

/**
 * Simple functions
 */
//echo 'I am a simple text [1]';
//echo 'I am a simple text [2]';
//echo 'I am a simple text [3]';
//echo 'I am a simple text [4]';
//echo 'I am a simple text [5]';

//echo 'I am a simple text [6]', 'I am a simple text [7]', 'I am a simple text [8]';
//echo 'I am a simple text [9]' . 'I am a simple text [10]' . 'I am a simple text [11]';

/**
 * Bonus
 */
//$array = [
//	7, 3, 5, 9, 11, 5,
//	[1, 3, 4]
//];