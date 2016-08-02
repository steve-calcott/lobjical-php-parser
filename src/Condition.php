<?php

namespace Lobjical;

abstract class Condition {
    protected $values=array();
    protected $value;
    protected $type;
    protected $property;
    protected $comparisonLog = array();
    protected $adjective = "";
    protected $description = "";
    
    public function __construct($type, $data) {
        $this->type = $type;
        $this->property = $data->property;
        $this->values = isset($data->values) ? $data->values : null;
        $this->value = isset($data->value) ? $data->value : "";
        if (!is_array($this->values)) {
            $this->values = array($this->value);
        }
    }
    public function run ($data) {
        return false;
    }
    
    public function getLastComparisons () {
        return $this->comparisonLog;
    }
    
    protected function addComparisonEntry ($msg) {
        $this->comparisonLog[] = $msg;
        //error_log($msg);
    }
    
    public function clearLastComparisons () {
        $this->comparisonLog = array();
    }
    
    public function __toString() {
        $p = $this->property;
        $v = implode(", ",$this->values);
        return "CONDITION: ".$p." ".$this->type." ".$v;
    }
    
    /*
     * Allows us to turn paths like /user/id_str or /retweeted_status/entities/urls/-/expanded_url into values
     */
    public static function getValueFromPath ($obj, $path) {
        $parts = explode(".", $path);
        $val = $obj;

        for ($i=0; $i<count($parts); $i++) {
            $part = $parts[$i];
            if ($i==(count($parts)-1)) {
                if (is_string($part) || is_numeric($part)) {
                    if (is_object($val) && (isset($val->{$part}))) {
                        return $val->{$part};
                    }
                    elseif (is_array($val) && (isset($val[$part]))) {
                        return $val[$part];
                    }
                    else {
                        return null;
                    }
                }
                elseif (is_string($val) || is_numeric($val)) {
                    return $val;
                }
            }
            elseif (@is_array($val) && (in_array($part,array("*","+")))) { //Currently behaves the same!!
                $values = array();
                foreach ($val as $item) {
                    $values[] = self::getValueFromPath($item, $parts[$i+1]);
                }
                //echo "RETURNING: ".implode(",",$values);
                return ($values);
            }
            elseif (@is_array($val->{$part})) {
                $val = $val[$part];
            }
            elseif (@is_object($val->{$part})) {
                $val = $val->{$part};
            }
        }
        error_log("Expression path doesn't exist: ".$path);
        return null;//Path doesn't exist!
    }
    
    /**
     * Extracts a value or set of values from a param set... This is for using $vars.
     */
    protected static function getValueFromParameters ($value, $params=array()) {
        return $value;
    }
    
    protected function execute ($comparison, $value) {
        return false;
    }
    
    protected function getClassName () {
        $reflect = new \ReflectionClass($this);
        return $reflect->getShortName();
    }
    
    /**
     * Compares a string to a string or array of strings...
     */
    public static function stringContains ($needle, $haystack) {
        $vals = $haystack;
        if (!is_array($haystack)) {
            $vals = array($haystack);
        }
        for ($i=0; $i<count($vals); $i++) {
            $h = $vals[$i];
            //error_log(__FUNCTION__."(): Check '$h' contains '$needle'");
            $rx = "/".$needle."/i";
            if (preg_match($rx, $h)) {
                return true;
            }
        }
        return false;
    }
    public static function stringEqual ($needle, $haystack) {
        $vals = $haystack;
        if (!is_array($haystack)) {
            $vals = array($haystack);
        }
        
        for ($i=0; $i<count($vals); $i++) {
            $h = $vals[$i];
            //error_log(__FUNCTION__."(): Check $h equals $needle");
            $rx = "/^".$needle."$/i";
            if (preg_match($rx, $h)) {
                return true;
            }
        }
        return false;
    }
    
    public static function greaterThan ($value, $comparison, $includeEqual=false) {
        //Target is the lobjical threshold. Value is from the data structure
        if (is_array($value) && count($value)>0) {
            $value = $value[0];
        }
        //error_log(__FUNCTION__."(): Check $value is greater than $comparison".($includeEqual?" (or equal)":""));
        return $includeEqual ? ($value>=$comparison) : ($value>$comparison);
    }

    public static function lessThan ($value, $comparison, $includeEqual=false) {
        //Target is the lobjical threshold. Value is from the data structure
        if (is_array($value) && count($value)>0) {
            $value = $value[0];
        }
        //error_log(__FUNCTION__."(): Check $value is less than $comparison".($includeEqual?" (or equal)":""));
        return $includeEqual ? ($value<=$comparison) : ($value<$comparison);
    }
    
    public static function regularExpression ($value, $rx) {
        
    }
    
    /**
     * Matches the type of $value as one of:
     * string, number, array, object, date, boolean, null
     */
    public static function typeMatches ($value, $type) {
        $types = array("string", "number", "array", "object", "date", "boolean", "null");
        $phpType = gettype($value);
        //....?
    }
}
