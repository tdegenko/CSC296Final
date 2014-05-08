<?php
/*
* USERDAL.php - Data Abstraction Layer for PokeTrade database
* 
*/
require_once 'dbsetup.php';
//  private $address, $contact;

class user{
    //from user
    private $name, $address, $contact, $passwd;
    static private $public_attrs=array("name","address", "contact","passwd");
    
	static public function getRAttrs(){
        return self::$public_attrs;
    }
    //generic getter/setter method
    function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }
        if(strncasecmp($method,"set",3)==0){
            if(in_array($var,self::$public_attrs) and count($params)==1){
                try{
                    $this->$var=$params[0];
                    $sql =  "UPDATE users
                             SET :attr=:val
                             WHERE name=:n;"  
                    $stmt = $db->prepare($sql);
                    $params = array(
                        ":attr" => $var,
                        ":val"  => $this->$var,
                        ":n"   => $this->$name,
                    );
                    $stmt->execute($params);
                }catch(PDOException $ex) {
                    echo("Could not update requested user.\n");
                }
                
            }else{
                return -1;
            }
        }
    }
    
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
	static public function findByName($name){
        try{
            global $db;
            $sql = "SELECT * FROM users WHERE name=:name";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":name" => $name));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "user");
        }catch(PDOException $ex) {
            echo("Could not find requested user.\n");
        }
    }
	
    static public function findByNameAndPasswd($name, $passwd){
        try{
            global $db;
            $sql = "SELECT * FROM users WHERE name=:name AND passwd=:passwd";
			$stmt = $db->prepare($sql);
            $stmt->execute(array(":name" => $name,":passwd" => $passwd));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "user");
        }catch(PDOException $ex) {
            echo("Could not find requested user.\n");
        }
    }
    
	function __construct($attrs){
        if(!isset($attrs)){
            return;
        }
        try{
            global $db;
            foreach ($attrs as $key=>$value){
                if(in_array($key,array_keys(get_object_vars($this))) and (!is_null($value)) and $value !=""){
                    $this->$key=$value;
                }
            }
            $db->beginTransaction();
            $sql="INSERT INTO users(name,address,contact,password) ".
            "VALUES (
:name,address,contact,password); ";
            $params=array();
            foreach(self::$poke_attrs as $key){
                $params[$key]=$this->$key;
            }
            $stmt = $db->prepare($sql);
            if(!$stmt){
                $db->rollBack();
                $error = "Could not add user";
                 throw new Exception($error);
            }
            if(!$stmt->execute($params)){
                $db->rollBack();
                $error = "Could not add user";
                 throw new Exception($error);
            }
            
            $db->commit();
        }catch(PDOException $ex) {
            echo("Could not create user.\n");
        }
    
}

