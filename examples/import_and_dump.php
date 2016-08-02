<?php

require_once __DIR__."/../vendor/autoload.php";

/**
 * This file simply loads content from a JSON file, passes the stdClass to the LobjicalParser and then
 * uses built-in __toString methods to dump out an outline of what the structure looks like.
 */

//Load the companion json file and json_decode (to stdClass, though can also use arrays(?))
$dataFileLocation = __DIR__."/json/data/basic_data.json";
$lobjFileLocation = __DIR__."/json/lobjical/basic.json";
if (!file_exists($dataFileLocation) | !file_exists($lobjFileLocation)) {
    die("Can't load data or lobjical JSON files: $dataFileLocation or $lobjFileLocation\n");
}

$dataFile = file_get_contents($dataFileLocation);
$lobjFile = file_get_contents($lobjFileLocation);

$data = json_decode($dataFile);
if (json_last_error()) {
    die("Can't parse JSON file: ".$dataFileLocation);
}
$lobjFile = json_decode($lobjFile);
if (json_last_error()) {
    die("Can't parse JSON file: ".$lobjFileLocation);
}

//Create a new LobjicalParser instance:
$x = new Lobjical\LobjicalClient;
$parser = $x->createParser($lobjFile);
//Loop through data and check:
$num=0;
$params = array(
    '$zips'=>array("90210","12345","78912")
);

foreach ($data->customers as $customer) {
    $num++;
    echo "\nChecking customer $num... ";
    $result = $parser->run($customer, $params);
    if ($result->getPasses()) {
        echo "PASS!";
        //Passes!
    }
    else {
        echo "FAIL!";
        print_r($result);
        //fails.
    }
    die;
}
print_r($params);
echo "\n";