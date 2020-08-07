<?php

require "thread.php";

function doSomething($res, $t) {
    sleep($t);
    exit($res);
}

$thread1 = new Thread('doSomething');
$thread2 = new Thread('doSomething');
$thread3 = new Thread('doSomething');

$thread1->start(3, 3);
$thread2->start(2, 4);
$thread3->start(1, 7);

// while ($thread1->isAlive(1) || $thread2->isAlive(2) || $thread3->isAlive(3));

$status = true;

 $a = true;
 $b = true;
 $c = true;

while($status){

    if (!$thread1->isAlive(1) && $a) {
        $a = false;
        echo "Thread 1 exit code (should be 3): " . $thread1->getExitCode() . "\n";
    }
    if (!$thread2->isAlive(2) && $b) {
        $b = false;
        echo "Thread 2 exit code (should be 2): " . $thread2->getExitCode() . "\n";
    }
    if (!$thread3->isAlive(3) && $c) {
        $c = false;
        echo "Thread 3 exit code (should be 1): " . $thread3->getExitCode() . "\n";
    }

    if (!$a && !$b && !$c) {
        $status = false;
    }
}

// echo "Thread 2 exit code (should be 2): " . $thread2->getExitCode() . "\n";
// echo "Thread 3 exit code (should be 1): " . $thread3->getExitCode() . "\n";