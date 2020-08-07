<?php

class myGenerator {
    protected $generator = null;
    protected $max_elements = 0;

    // public $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
	// public $chars = "0123456789";
	public $chars = "abcd";

    function __construct($data) {

        $this->chars = str_split($this->chars);

        $start = $data['start'];
        $stop = $data['stop'];

        $this->repeat = $data['repeat'];

        $this->max_elements = pow(count($this->chars), $this->repeat);

        if ($stop > $this->max_elements) {
            $stop = $this->max_elements;
        }

        $this->generator = $this->genCombinations($stop, $start);
    }

    public function maxElements() {
        return $this->max_elements;
    }

    public function generator() {
        return $this->generator;
    }

    protected function genCombinations($stop, $start = 0) {

        // Iterate and yield:
        for($i = $start; $i < $stop; $i++){
            yield $this->getCombination($i);
        }
    }

    // State-based way of generating combinations:
    protected function getCombination($index) {

        $result = "";
        for($i = 0; $i < $this->repeat; $i++) {
            // Figure out where in the array to start from, given the external state and the internal loop state
            $pos = $index % count($this->chars);

            // Append and continue
            $result .= $this->chars[$pos];
            $index = ($index - $pos) / count($this->chars);
        }

        return $result;
    }
}
