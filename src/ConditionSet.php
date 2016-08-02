<?php

namespace Lobjical;

class ConditionSet extends Condition {
    protected $children=array();
    protected $type="AND";
    
    public function __construct($data) {
        for ($i=0; $i<count($data); $i++) {
            $this->children[] = \Lobjical\ConditionFactory::create($data[$i]);
        }
    }
    
    public function run ($data) {
        $res = new \Lobjical\Condition\Result();
        return $res;
    }
    
    public function getLastComparisons () {
        $comps = array();
        for ($i=0; $i<count($this->children); $i++) {
            $comps[] = $this->children[$i]->getLastComparisons();
        }
        return $comps;
    }

    public function clearLastComparisons () {
        for ($i=0; $i<count($this->children); $i++) {
            $this->children[$i]->clearLastComparisons();
        }
        return true;
    }
    
    public function __toString () {
        $s = "";
        foreach ($this->children as $child) {
            $s.=$child.", ";
        }
        return $s;
    }
}
