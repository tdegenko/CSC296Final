<?php
/*
* USERDAL.php - Data Abstraction Layer for PokeTrade database
* 
*/
require_once 'dbsetup.php';
//  private $address, $contact;

class users{
    //from user
    private $name, $address, $contact, $passwd;
    static private $public_attrs=array("name","address", "contact");
    
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
                             WHERE name=:n";  
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
            $sql = "SELECT name,address,contact FROM users WHERE name=:name";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":name" => $name));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "users");
        }catch(PDOException $ex) {
            echo("Could not find requested user.\n");
        }
    }
	
    static public function authFindByName($name){
        try{
            global $db;
            $sql = "SELECT name,address,contact,passwd FROM users WHERE name=:name";
			$stmt = $db->prepare($sql);
            $stmt->setFetchMode( PDO::FETCH_CLASS, 'users',NULL);
            $stmt->execute(array(":name" => $name));
            return $stmt->fetch(PDO::FETCH_CLASS);
        }catch(PDOException $ex) {
            echo("Could not find requested user.\n");
        }
    }
    function verifyPasswd($pass){
        if(crypt($pass,$this->passwd)==$this->passwd){
            unset($this->passwd);
            return true;
        }else{
            return false;
        }
    }
    static private salt($length=22){
        $CHARS='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
        }
	static public function addUser($attrs){
        if(!is_null($attrs)){
            return;
        }
        try{
            global $db;
            foreach ($attrs as $key=>$value){
                if(in_array($key,array_keys(get_object_vars($this))) and (!is_null($value)) and $value !=""){
                    if ($key=="passwd"){
                        if(CRYPT_BLOWFISH=1){
                            $this->$key=crypt($value,'$2y$10$'.self::salt().'$');
                        }else{
                            $this->$key=crypt($value);;
                        }
                    }else{
                        $this->$key=$value;
                    }
                }
            }
            $db->beginTransaction();
            $sql="INSERT INTO users(name,address,contact,passwd) ".
            "VALUES (
:name,:address,:contact,:passwd); ";
            $params=array();
            foreach(self::$public_attrs as $key){
                if(is_null($this->$key)){
                    $params[":".$key]="";
                }else{
                    $params[":".$key]=$this->$key;
                }
            }
            $params[':passwd']=$this->passwd;
            $stmt = $db->prepare($sql);
            if(!$stmt){
                $db->rollBack();
                $error = "Could not add user";
                 throw new Exception($error);
            }
            echo "$sql\n";
            print_r($params);
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
    
}

