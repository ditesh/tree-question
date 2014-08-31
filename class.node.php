<?php

class Node {

    private $val;
    public $parent;
    public $left;
    public $right;

    public function __construct($val) {
        $this->val($val);
    }

    public function val($val=NULL) {

        if (is_null($val)) return $this->val;
        else $this->val = $val;

    }

    public function ord() {
        return ord($this->val);
    }
}
