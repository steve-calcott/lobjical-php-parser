<?php
namespace Lobjical;

class LobjicalClient {
    public function createParser (\stdClass $data) {
        return new Parser($data);
    }
    
    public static function getValueAsString ($val) {
        switch (gettype($val)) {
            case "boolean":
                return $val ? "true" : "false";
            case "array":
                return explode(",", $val);
            case "object":
                return "(object)";
            case "NULL":
                return "NULL";
            case "string":
                return '"'.$val.'"';
            default:
                return $val;
        }
    }
}
