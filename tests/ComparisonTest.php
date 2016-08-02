<?php
require_once __DIR__."/../vendor/autoload.php";

class comparisonTest extends PHPUnit_Framework_TestCase {
    /* Tests to be added:
     * getValueFromPath
     *
     */
    
    public function testEquality () {
        $jsonStr = <<<jsonstr
{
    "eq": {
        "property": "enabled",
        "value": true
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("enabled"=>true));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("enabled"=>false));
        $this->assertFalse($result->getPasses());
    }
    
    public function testExists () {
        $jsonStr = <<<jsonstr
{
    "exists": {
        "property": "enabled"
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("enabled"=>true));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("foo"=>false));
        $this->assertFalse($result->getPasses());
    }

    public function testLessThan () {
        $jsonStr = <<<jsonstr
{
    "lt": {
        "property": "counter",
        "value": 10
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("counter"=>9));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>10));
        $this->assertFalse($result->getPasses());
    }

    public function testLessThanEqual () {
        $jsonStr = <<<jsonstr
{
    "lte": {
        "property": "counter",
        "value": 10
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("counter"=>9));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>10));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>11));
        $this->assertFalse($result->getPasses());
    }

    public function testGreaterThan () {
        $jsonStr = <<<jsonstr
{
    "gt": {
        "property": "counter",
        "value": 10
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("counter"=>11));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>10));
        $this->assertFalse($result->getPasses());
    }

    public function testGreaterThanEqual () {
        $jsonStr = <<<jsonstr
{
    "gte": {
        "property": "counter",
        "value": 10
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("counter"=>11));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>10));
        $this->assertTrue($result->getPasses());
        $result = $parser->run(array("counter"=>9));
        $this->assertFalse($result->getPasses());
    }
    public function testContains () {
        $jsonStr = <<<jsonstr
{
    "contains": {
        "property": "name",
        "value": "smith"
    }
}
jsonstr;
        
        $json = json_decode($jsonStr);
        $lc = new Lobjical\LobjicalClient;
        $parser = $lc->createParser($json);
        
        $result = $parser->run(array("name"=>"Mr William Smith"));
        $this->assertTrue($result->getPasses());

        $result = $parser->run(array("name"=>"Smithsonian Museum"));
        $this->assertTrue($result->getPasses());

        $result = $parser->run(array("name"=>"Mr Schmitt"));
        $this->assertFalse($result->getPasses());
    }

}
