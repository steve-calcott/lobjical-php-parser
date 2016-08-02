<?php

namespace Lobjical;

class ConditionFactory {
    public static function create (\stdClass $obj) {
        foreach ($obj as $name=>$condition) {
            $instance = self::createFromType($name, $condition);
            return $instance;
        }
        return null; //We don't error - there could be a reason for empty objects.
    }
    
    private static function createFromType ($name, $condition) {
        switch (strtolower($name)) {
            case "and":
                $ret = new \Lobjical\ConditionSet\AndSet($condition);
                break;
            case "or":
                $ret = new \Lobjical\ConditionSet\OrSet($condition);
                break;
            case "xor":
                $ret = new \Lobjical\ConditionSet\XOrSet($condition);
                break;
            case "not":
                $ret = new \Lobjical\ConditionSet\NotSet($condition);
                break;
            
            case "contains":
                $ret = new \Lobjical\Condition\Contains($name, $condition);
                break;
            case "eq":
                $ret = new \Lobjical\Condition\Equals($name, $condition);
                break;
            case "gt":
                $ret = new \Lobjical\Condition\GreaterThan($name, $condition);
                break;
            case "lt":
                $ret = new \Lobjical\Condition\LessThan($name, $condition);
                break;
            case "gte":
                $ret = new \Lobjical\Condition\GreaterThan($name, $condition, true);
                break;
            case "lte":
                $ret = new \Lobjical\Condition\LessThan($name, $condition, true);
                break;
            case "exists":
                $ret = new \Lobjical\Condition\Exists($name, $condition);
                break;
            default:
                error_log("Ignoring unknown condition type: ".$name);
                $ret = null;
                break;
        }
        return $ret;
    }
}