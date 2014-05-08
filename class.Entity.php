<?php
require_once 'class.PropertyObject.php';
require_once 'class.PhoneNumber.php';
require_once 'class.Address.php';
require_once 'class.EmailAddress.php';

abstract class Entity  extends PropertyObject{
    
    private $_emails;
    private $_addresses;
    private $_phonenumbers;
    
    public function __construct($entity_id) {
        
       $arData = DataManager::getEntityData($entity_id);
       parent::__construct($arData);
       
      $this->propertyTable['entity_id'] = 'entity_id';
      $this->propertyTable['name1'] = 'sname1';
      $this->propertyTable['name2'] = 'sname2';
      $this->propertyTable['type'] = 'ctype';
      
      $this->_emails = DataManager::getEmailObjectsForEntity($entity_id);
      $this->_addresses = DataManager::getAddressObjectsForEntity($entity_id);
      $this->_phonenumbers = DataManager::getPhoneNumberObjectsForEntity($entity_id);
    }
    
    function setID($val){
        throw new Exception('You may not alter the value of the ID field');
    }
    function setEntity($val){
        $this->setID($val);
    }
    function phoneNumbers($index){
        if(!isset($this->_phonenumbers[$index])){
            throw new Exception('Invalid phone number specified');
        }else{
            return $this->_phonenumbers[$index];
        }
    }
    function getNumberofPhoneNumbers(){
        return sizeof($this->_phonenumbers);
    }
    function addPhoneNumber(PhoneNumber $phone){
        $this->_phonenumbers[] = $phone;
    }
    function addresses($index){
         if(!isset($this->_addresses[$index])){
             throw new Exception('Invalid address Specified');
         }else{
             return $this->_addresses[$index];
         }
     }
     function getNumberofAddresses(){
         return sizeof($this->_addresses);
     }
     function addAddress(Address $address){
         $this->_addresses[] = $address;
     }
     
     function emails($index){
         if(!isset($this->_emails[$index])){
             throw new Exception('Invalid email Specified');
         }else{
             return $this->_emails[$index];
         }
     }
     function getNumberOfEmails(){
         return sizeof($this->_emails);
     }
     function addEmails(Email $email){
         $this->_emails[] = $email;
     }
     public function validate(){
         //common validation routines
     }
    }