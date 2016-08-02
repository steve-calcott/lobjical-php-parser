<?php
namespace Lobjical;

class Parser {
    private $conditions;
    
    public function __construct(\stdClass $data) {
        $validation = Validator::isValidStructure($data);
        if (!$validation) {
            $report = Validator::getReport();
            throw new \Lobjical\Exception\ValidationException("Invalid structure supplied to Parser. ".$report);
        }
        
        $this->conditions = ConditionFactory::create($data);
    }
    
    public function run($content) {
        return $this->conditions->run($content);
    }
}