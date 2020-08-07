<?php

function pr($data, $type = 0) {
    print '<pre>';
    print_r($data);
    print '</pre>';
    if ($type != 0) {
        exit();
    }
}

function get_processes() {
    $get = @file_get_contents('https://tg.brigu.net/api/numberofprocesses');
    $get = json_decode($get);
    
    if(is_object($get)){
       return (int)$get->count;
    }
    return 0;
}

function set_status($id) {
    $get = @file_get_contents('https://tg.brigu.net/api/proces/' . $id );
    $get = json_decode($get);
    
    if(is_object($get)){
       return (bool)$get->status;
    }

    return false;
}

function initCombinations($data) {

    $chars = $data['chars'];
    $repeat = $data['repeat'];
    $start = $data['start'];
    $stop = $data['stop'];

    $permCount = pow(count($chars), $repeat);
    
    $generator = genCombinations($chars, $repeat, $stop, $start);

    return (object)[
        "generator" => $generator,
        "permCount" => $permCount,
    ];
}

function genCombinations($values, $count, $stop, $start = 0) {

	// Iterate and yield:
	for($i = $start; $i < $stop; $i++){
        yield getCombination($values, $count, $i);
    }
}

// State-based way of generating combinations:
function getCombination($values, $count, $index) {

	$result = "";
	for($i = 0; $i < $count; $i++) {
		// Figure out where in the array to start from, given the external state and the internal loop state
		$pos = $index % count($values);

		// Append and continue
		$result .= $values[$pos];
		$index = ($index-$pos)/count($values);
	}

	return $result;
}
