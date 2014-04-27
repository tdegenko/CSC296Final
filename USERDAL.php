<?php
/*
* USERDAL.php - Data Abstraction Layer for PokeTrade database
* 
*/
require_once 'dbsetup.php';
//  private $address, $contact;

class user{
    //from user
    private $name, $address, $contact;
    private $public_attrs=["name","address", "contact"];
    
    //generic getter/setter method
    function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }
        if(strncasecmp($method,"set",3)==0){
            if(in_array($var,$public_attrs) and count($params)==1){
                try{
                    $this->$var=$params[0];
                    $sql =  "UPDATE user
                             SET :attr=:val
                             WHERE name=:n;"  
                    $stmt = $db->prepare($sql);
                    $params = array(
                        ":attr" => $var,
                        ":val"  => $this->$var,
                        ":n"   => $this->name,
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
            $sql = "SELECT * FROM user WHERE name=:name";
			$stmt = $db->prepare($sql);
            $stmt->execute(array(":name" => $name));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "user");
        }catch(PDOException $ex) {
            echo("Could not find requested user.\n");
        }
    }
    
    
}

