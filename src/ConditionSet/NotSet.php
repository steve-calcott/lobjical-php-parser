<?php

namespace Lobjical\ConditionSet;

class NotSet extends \Lobjical\ConditionSet {
    protected $type="NOT";
    
    public function run ($data) {
        $totalPasses = $totalFails = 0;
        $totalChildren = count($this->children);
        
        for ($i=0; $i<$totalChildren; $i++) {
            $child = $this->children[$i];
            $cres = $child->run($data);
            if ($cres->getPasses()) {
                $totalPasses++;
            }
            else {
                $totalFails++;
            }
        }
        
        $res = new \Lobjical\Condition\Result();
        $pass = ($totalPasses<=0);
        if (!$pass) {
            error_log("NotSet FAIL:: At least one of the conditions passed.");
        }
        else {
            error_log("NotSet:: PASS");
        }
        $res->setPasses($pass);
        return $res;
    }
}