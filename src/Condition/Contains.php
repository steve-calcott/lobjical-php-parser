<?php

namespace Lobjical\Condition;

class Contains extends \Lobjical\Condition {
    public function run ($data) {
        $res = new \Lobjical\Condition\Result();
        $val = self::getValueFromPath($data, $this->property);
        if (is_null($val)) return $res;
        $v = $val;
        if (is_array($v)) $v = "[".implode(", ",$v)."]";

        for ($i=0; $i<count($this->values); $i++) {
            //error_log($this->property." is equal to ".$v." checking if it CONTAINS ".$this->values[$i]);
            $compval = $this->values[$i];
            $valtype = gettype($val);
            
            //Cast as strings for now:
            $v = "$v";
            $compval = "$compval";
            
            if (self::stringContains($compval, $val)) {
                $this->addComparisonEntry("PASS: ".$this->property." contains ".$this->values[$i]);
                $res->setPasses(true);
                return $res;
            }
        }
        $p = "[".implode(", ",$this->values)."]";
        $this->addComparisonEntry("FAIL: ".$this->property." doesn't contain $p");
        return $res; 
    }
}