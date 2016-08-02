<?php

namespace Lobjical\ConditionSet;

class AndSet extends \Lobjical\ConditionSet {
    protected $type="AND";
    
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
        $pass = ($totalPasses==$totalChildren);
        if (!$pass) {
            error_log("NotSet:: All of the conditions passed.");
        }
        else {
            error_log("NotSet:: PASS");
        }
        $res->setPasses($pass);
        return $res;
    }
}