<?php
require_once 'class.Entity.php';
require_once 'class.Organization.php';

class Individual extends Entity{
    public function __construct($user_id) {
        parent::__construct($user_id);
        
        $this->propertyTable['firstname'] = 'name1';
        $this->propertyTable['lastname'] = 'name2';
    }
    
    public function __toString() {
        return $this->firstname . ' '. $this->lastname;
    }
    public function getEmployer(){
        return DataManger::getEmployer($this->id);
    }
    public function validate(){
        parent::validate();
        
        //add individual specific validation rules
    }
}

