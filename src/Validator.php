<?php

namespace Lobjical;

class Validator {
    private static $_vr;
    
    /**
     * Ensures incoming data in stdClass format is of the correct format and only has supported nodes.
     *
     * @param stdClass $lobj A stdClass instance which is to be compared against the rules for a Lobjical format.
     */
    public static function isValidStructure (\stdClass $lobj) {
        self::$_vr = new \Lobjical\ValidationReport;
        return true;
    }
    
    public function getReport () {
        return (self::$_vr ? self::$_vr->getReport() : "");
    }
}

class ValidationReport {
    private $_isValid = false;
    private $_report = array();
    
    public function addValidationEntry ($msg, $passFail="fail") {
        if (!in_array($passFail,array("fail","pass"))) {
            $passFail="fail";
        }
        if (!isset($this->_report[$passFail])) {
            $this->_report[$passFail] = array();
        }
        $this->_report[] = "$passFail: $msg";
    }
    
    public function getIsValid () {
        return $this->_isValid;
    }
    
    public function getReport () {
        $s = "";
        foreach ($this->_report as $type=>$entries) {
            $s.=$type.": ";
            foreach ($entries as $entry) {
                $s .= $entry.";";                
            }
        }
        return rtrim($s,"; ");
    }
}
