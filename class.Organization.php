<?php

require_once 'class.Entity.php';
require_once 'class.Individual.php';

 class Organization extends Entity{
     public function __construct($user_id) {
        parent::__construct($user_id);
        
        $this->propertyTable['name'] = 'name1';
    }
    
    public function __toString() {
        return $this->firstname . ' '. $this->lastname;
    }
    public function getEmployees(){
        return DataManger::getEmployees($this->id);
    }
    public function validate(){
        parent::validate();
        
        //add individual specific validation rules
    }
 }

