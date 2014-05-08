<?php
require_once('class.Entity.php');
require_once('class.Individual.php');
require_once('class.Organization.php');

class DataManager{
    private static function _getConnection(){
        static $hDB;
        
        if(isset($hDB)){
            return $hDB;
        }
        
        $hDB = mysql_connect('localhost', 'root', 'elephant')
            or die("Failure connecting to the Database!");
        mysql_select_db('contact_manager') or die('Failure selecting the Database');
        return $hDB;
    }
    
    public static function getAddressData($addressid){
        $sql = "SELECT * FROM entityaddress WHERE addressid = $addressid";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!($res && mysql_num_rows($res))){
            die("Failed getting address data for address $addressid");
        }
        return mysql_fetch_assoc($res);
    }
    public static function getEmailData($emailid){
        $sql = "SELECT * FROM entityemail WHERE emailid = $emailid";
        $res = mysql_query($sql, DataManager::_getConnection());
        
        if (!($res && mysql_num_rows($res))){
            die("Failed getting email data for email $emailid");
        }
        return mysql_fetch_assoc($res);
    }
    public static function getPhoneNumberData($phoneid){
        $sql = "SELECT * FROM entityphone WHERE phoneid= $phoneid";
        $res = mysql_query($sql, DataManager::_getConnection());
        
        if (!($res && mysql_num_rows($res))){
            die("Failed getting phone data for phone number $phoneid");
        }
        return mysql_fetch_assoc($res);
    }
    public static function getEntityData($entity_id){
        $sql = "SELECT * FROM entities WHERE entity_id = $entity_id";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!($res && mysql_num_rows($res))){
            die("Failed getting entity $entity_id");
        }
        return mysql_fetch_assoc($res);
    }
    public static function getAddressObjectsForEntity($entity_id){
        $sql = "SELECT addressid FROM entityaddress WHERE   entity_id = $entity_id";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!$res){
            die("Failed getting address data for entity $entity_id");
        }
        if(mysql_num_rows($res)){
            $objs = array();
            while ($rec = mysql_fetch_assoc($res)){
                $objs = new Address($rec['addressid']);
            }
            return $objs;
        } else {
            return array();
        }
    }
    
    public static function getEmailObjectsForEntity($entity_id){
        $sql = "SELECT emailid FROM entityemail WHERE entity_id = $entity_id";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!$res){
            die("Failed getting email data for entity $entity_id");
        }
        if(mysql_num_rows($res)){
            $objs = array();
            while ($rec = mysql_fetch_assoc($res)){
                $objs = new EmailAddress($rec['emailid']);
            }
            return $objs;
        } else {
            return array();
        }
    }
    public static function getPhoneNumberObjectsForEntity($entity_id){
         $sql = "SELECT phoneid FROM entityphone WHERE entity_id = $entity_id";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!$res){
            die("Failed getting phone data for entity $entity_id");
        }
        if(mysql_num_rows($res)){
            $objs = array();
            while ($rec = mysql_fetch_assoc($res)){
                $objs = new Address($rec['phoneid']);
            }
            return $objs;
        } else {
            return array();
        }
    }
    public static function getEmployer($individulID){
        $sql = "SELECT organizationid FROM entityemployee WHERE individualid = $individualid";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!($res && mysql_num_rows($res))){
            die("Failed getting employer info for individual $individulid");
        }
        
        $row = mysql_fetch_assoc($res);
        if($row){
            return new Organization($row['organizationid']);
        }else{
            return null;
        }
    }
    public static function getEmployees($orgID){
        $sql = "SELECT individualid FROM entityemployee WHERE organizationid = $orgID";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!($res && mysql_num_rows($res))){
            die("Failed getting employee info for org $orgID");
        }
        if(mysql_num_rows($res)){
            $objs = array();
            while ($rec = mysql_fetch_assoc($res)){
                $objs[] = new Individual($rec['individualid']);
            }
            return $objs;
        } else {
            return array();
        }
    }
    public static function getAllEntitiesAsObjects(){
        $sql = "SELECT entity_id, type FROM entities";
        $res = mysql_query($sql, DataManager::_getConnection());
        if(!$res){
            die("Failed getting all entities");
        }
        if(mysql_num_rows($res)){
            $objs = array();
            while ($rec = mysql_fetch_assoc($res)){
                if($rec['type'] == 'I'){
                $objs[] = new Individual($rec['entity_id']);
                }elseif ($rec['type'] == 'O') {
                 $objs[] = new Organization($rec['entity_id']);
                }else{
                    die("Unknown entity type {$rec['type']} encountered");
                }
            }
            return $objs;
        } else {
            return array();
        }
    }
    
    
}

