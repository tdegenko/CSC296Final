<?php
/*
* RequestsDAL.php - Data Abstraction Layer for PokeTrade database
*
*/
require_once 'dbsetup.php';
require_once 'include.php';
// private $ID, originalTrainer,moveName1, moveName2, moveName3, moveName4,

class requests{
    //from user
    private $ID, $originalTrainer,$moveName1, $moveName2, $moveName3, $moveName4;
    static private $public_attrs=array("ID","originalTrainer","moveName1","moveName2","moveName3", "moveName4");
    
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
                    $sql = "UPDATE requests
SET :attr=:val
WHERE ID=:ID;
AND originalTrainer=:originalTrainer
AND trainerName=:trainerName";
                    $stmt = $db->prepare($sql);
                    $params = array(
                        ":attr" => $var,
                        ":val" => $this->$var,
                        ":ID" => $this->$ID,
":originalTrainer" => $this->$originalTrainer,
    ":trainerName" => $this->$trainerName
                    );
                    $stmt->execute($params);
                }catch(PDOException $ex) {
                    echo("Could not update requests table.\n");
                }
            }else{
                return -1;
            }
        }
    }
    
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByFDs($ID, $originalTrainer, $trainerName){
        try{
            global $db;
            $sql = "SELECT * FROM requests WHERE name=:name AND originalTrainer=:originalTrainer AND trainerName=:trainerName";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":name" => $name, ":originalTrainer" => $originalTrainer, ":trainerName" => $originalTrainer));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "requests");
        }catch(PDOException $ex) {
            echo("Could not find request.\n");
        }
    }
	
	static public function findRequested($trainerName){
        try{
            global $db;
            $sql = "SELECT * FROM requests WHERE (SELECT trainerName FROM pokemon WHERE requests.ID=pokemon.ID AND requests.originalTrainer=pokemon.originalTrainer)=:trainerName";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":trainerName" => $trainerName));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "requests");
        }catch(PDOException $ex) {
            echo("Could not find request.\n");
        }
    }
	
	static public function findMyRequests($trainerName){
        try{
            global $db;
            $sql = "SELECT * FROM requests WHERE trainerName=:trainerName";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":trainerName" => $trainerName));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "requests");
        }catch(PDOException $ex) {
            echo("Could not find request.\n");
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
            $sql="INSERT INTO requests(ID,originalTrainer,trainerName,status) ".
            "VALUES (:ID,:originalTrainer,:trainerName,:status); ";
            $params=array();
            foreach(self::$public_attrs as $key){
                $params[$key]=$this->$key;
            }
            $stmt = $db->prepare($sql);
            if(!$stmt){
                $db->rollBack();
                $error = "Could not add pokemon";
                 throw new Exception($error);
            }
            if(!$stmt->execute($params)){
                $db->rollBack();
                $error = "Could not add pokemon";
                 throw new Exception($error);
            }
            setstatus("pending");
        }catch(PDOException $ex) {
            echo("Could not find requested pokemon.\n");
        }
}
}