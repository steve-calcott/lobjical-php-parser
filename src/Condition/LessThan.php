<?php

namespace Lobjical\Condition;

class LessThan extends \Lobjical\Condition {
    protected $adjective = "less than";
    protected $description = "less than";
    protected $includeEqual=false;
    
    public function __construct ($type, $data, $includeEqual=false) {
        $this->includeEqual = $includeEqual;
        parent::__construct($type, $data);
    }
    
    public function run ($data, $params=array()) {
        $res = new \Lobjical\Condition\Result();
        $val = self::getValueFromPath($data, $this->property);
        $this->values = self::getValueFromParameters($this->values, $params);
        for ($i=0; $i<count($this->values); $i++) {
            $compval = floatval($this->values[$i]);
            $val = floatval($val);
            $valtype = gettype($val);
            $type = $this->getClassName();
            
            if (self::lessThan($val, $compval, $this->includeEqual)) {
                $this->addComparisonEntry("PASS: ".$this->property." is ".$this->description." ".$compval);
                $res->setPasses(true);
            }
            else {
                $this->addComparisonEntry("FAIL: ".$this->property." is not ".$this->description." ".$compval);
                $res->setPasses(false);
            }
        }
        return $res;
   }
}