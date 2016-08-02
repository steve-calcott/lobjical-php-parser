<?php
require_once __DIR__."/../vendor/autoload.php";

class compoundTest extends PHPUnit_Framework_TestCase {
    /**
     * Checks whether a NOT block correctly works. In the example below we want both conditions to NOT be true.
     *
     * enabled should NOT equal false
     * name should not contain 
     */
    public function testNot () {
        $jsonStr = <<<jsonstr
{
    "NOT": [
        {
            "eq": {
                "property": "enabled",
                "value": true
            }
        },
        {
            "lt": {
                "property": "total",
                "value": 50
            }
        }
    ]
}
jsonstr;

        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("enabled"=>false, "total"=>44));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("enabled"=>true, "total"=>66));
        $this->assertFalse($result->getPasses());
    }
}
