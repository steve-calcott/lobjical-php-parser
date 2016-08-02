<?php

namespace Lobjical\ConditionSet;

class OrSet extends \Lobjical\ConditionSet {
    protected $type="OR";
    
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
        $pass = ($totalPasses>0);
        if (!$pass) {
            error_log("NotSet:: None of the conditions passed.");
        }
        else {
            error_log("NotSet:: PASS");
        }
        $res->setPasses($pass);
        return $res;
    }
}