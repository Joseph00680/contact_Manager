<?php
require_once ('interface.Validator.php');

abstract class PropertyObject implements Validator{
    //stores the name/value pairs that hook properties to database field names
    protected $propertyTable = array();
    
    //List the properties that have been modified
    protected $changedProperties = array();
    
    //actual data from the database
    protected $data;
    
    //any validation errors that might have occurred
    protected $errors = array();
    
    public function __construct($arData) {
        $this->data = $arData;
    }
    
    function __get($propertyName){
        if(!array_key_exists($propertyName, $this->propertyTable))
                throw new Exception ("Invalid property\"$propertyName\"!");
        if(method_exists($this, 'get'.$propertyName)){
            return call_user_func(array($this, 'get'.$propertyName));
        }else{
            return $this->data[$this->propertyTable[$propertyName]];
        }
    }
    
    function __set($propertyName, $value){
        if(!array_key_exists($propertyName, $this->propertyTable))
            throw new Exception("Invalid Property\"$propertyName \"!");
        if(method_exists($this,'set'.$propertyName)){
            return call_user_func(array($this, 'set'.$propertyName), $value);
        }else
            //if the value of the property really has changed  and it's not already in the changedProperties array add it.
            if ($this->propertyTable[$propertyName] != $value &&
                    !in_array($propertyName, $this->changedProperties)){
                $this->changedProperties[] = $propertyName;
                    }
              //Now set the new Value
              $this->data[$this->propertyTable[$propertyName]] == $value;
    }
    
    function  validate()
    {}
}
?>


