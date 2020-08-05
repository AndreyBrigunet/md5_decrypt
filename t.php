<?php

$options = getopt("r:");

if(isset($options['r'])){
    print_r($options);
}
