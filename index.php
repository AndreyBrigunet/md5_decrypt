<?php

error_reporting(-1);
ini_set('display_errors', 1);

define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('INC_DIR', DIR . 'inc' . DIRECTORY_SEPARATOR);

require_once DIR . 'functions.php';

$time_start = microtime(true);

$hash = file('hash.md5', FILE_IGNORE_NEW_LINES);
$chars = str_split("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%&'()*+,-./:;<=>?@[\]^_`{|}~");
// $chars = str_split("0123456789");
$repeat = 8;

$generator = genCombinations($chars, $repeat);

foreach ($generator as $key => $str) {
	// Do something with the value here
	// pr($value);
	$key = md5($str);

	echo $str;
	echo " - ";
	echo $key;
	echo "\n";
	
	if (in_array($key, $hash) ) {
		@file_get_contents('https://tg.brigu.net/api/decrypt/' .$str. '/' .$key );
	}
	
}



	
		
		
	
		


		// usleep(1);
		
		// if ($number > $max) {

		// 	$time_end = microtime(true);
		// 	$time = ($time_end - $time_start)/60;;
		// 	echo "Process Time: {$time} min \n";

		// 	$status = false;
		// }
		
