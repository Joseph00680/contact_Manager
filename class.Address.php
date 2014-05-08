<?php
require_once 'class.PropertyObject.php';

class Address extends PropertyObject{
   
    function __construct($addressid) {
        $arData = DataManager::getAddressData($addressid);
        
        parent::__construct($arData);
        
        $this->propertyTable['addressid'] = 'addressid';
        $this->propertyTable['entity_id'] = 'entity_id';
        $this->propertyTable['saddress1'] = 'saddress1';
        $this->propertyTable['saddress2'] = 'saddress2';
        $this->propertyTable['scity'] = 'scity';
        $this->propertyTable['cstate'] = 'cstate';
        $this->propertyTable['spostalcode'] = 'spostalcode';
        $this->propertyTable['stype'] = 'stype';
        
    }
    function validate() {
        if(strlen($this->state) != 2){
            $this->errors['state'] = 'Please choose a valid state';
        }
        if(strlen($this->zipcode) < 5 || strlen($this->zipcode) > 10){
            $this->errors['zipcode']= 'Please Enter a 5 or 9 digit zipcode';
        }
        if(!$this->address1){
            $this->errors['address1'] = 'Address 1 is a required field';
        }
        if(!$this->city){
            $this->errors['city'] = 'City is a required field';
        }
       if (sizeof($this->errors)){
           return false;
       }else{
           return true;
       }
    }
    function __toString() {
        return $this->address1 . ', '.
               $this->address2 . ', '.
               $this->city . ', '.
               $this->state. ' '. $this->zipcode;
    }
}
