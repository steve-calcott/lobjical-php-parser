<?php

namespace Lobjical\Condition;

class Exists extends \Lobjical\Condition {
    public function run ($data) {
        $res = new \Lobjical\Condition\Result();
        $val = self::getValueFromPath($data, $this->property);
        if (!is_null($val)) {
            $this->addComparisonEntry("PASS: ".$this->property." exists.");
            $res->setPasses(true);
        }
        else {
            $this->addComparisonEntry("FAIL: ".$this->property." does not exist");
        }
        return $res;
   }
}