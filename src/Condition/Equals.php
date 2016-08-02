<?php

namespace Lobjical\Condition;

class Equals extends \Lobjical\Condition {
    protected $adjective = "equal";
    protected $description = "equal to";
    
    public function run ($data, $params=array()) {
        $res = new \Lobjical\Condition\Result();
        $val = self::getValueFromPath($data, $this->property);
        $this->values = self::getValueFromParameters($this->values, $params);
        $v = $val;
        if (is_array($v)) $v = "[".implode(", ",$v)."]";

        for ($i=0; $i<count($this->values); $i++) {
            $compval = $this->values[$i];
            $valtype = gettype($val);
            $type = $this->getClassName();
            //error_log($this->property." is equal to ".\Lobjical\LobjicalClient::getValueAsString($val)." checking if it is ".$this->description." ".\Lobjical\LobjicalClient::getValueAsString($compval));
            switch ($valtype) {
                case "string":
                    if (self::stringEqual($compval, $val)) {
                        $this->addComparisonEntry("PASS: ".$this->property." equals ".$compval);
                        $res->setPasses(true);
                    }
                    break;
                default:
                    if ($val==$compval) {
                        $this->addComparisonEntry("PASS: ".$this->property." is ".$this->description." ".$compval);
                        $res->setPasses(true);
                    }
                return $res;
            }
        }

        $p = "[".implode(", ",$this->values)."]";
        $this->addComparisonEntry("FAIL: ".$this->property." is not ".$this->description." ".$p." is: ".$v);
        $res->setPasses(false);
        return $res;
    }
}