<?php

namespace Lobjical\Condition;

class Result {
    private $_passes=false;
    
    public function setPasses ($val) {
        $this->_passes = $val;
    }
    
    public function getPasses () {
        return $this->_passes;
    }
}