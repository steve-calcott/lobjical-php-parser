<?php

namespace Lobjical\ConditionSet;

class XOrSet extends \Lobjical\ConditionSet {
    protected $type="XOR";
    
    public function run ($data) {
        $totalPasses = $totalFails = 0;
        $totalChildren = count($this->children);
        
        for ($i=0; $i<$totalChildren; $i++) {
            $child = $this->children[$i];
            if ($child->run($data)) {
                $totalPasses++;
            }
            else {
                $totalFails++;
            }
        }
        
        $res = new \Lobjical\Condition\Result();
        $pass = ($totalPasses==1);
        if (!$pass) {
            error_log("XOrSet:: Zero or more than one conditions passed.");
        }
        else {
            error_log("XOrSet:: PASS");
        }
        $res->setPasses($pass);
        return $res;
    }
}