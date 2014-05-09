<?php
/*
* RequestsDAL.php - Data Abstraction Layer for PokeTrade database
*
*/
require_once 'dbsetup.php';
require_once 'include.php';
// private $ID, originalTrainer

class requests{
    //from user
    private $ID, $originalTrainer, $trainerName, $dateCreated, $status;
    
    //generic getter/setter method
    function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }else{
                return -1;
        }
    }
    
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByFDs($ID, $originalTrainer, $trainerName){
        try{
            global $db;
            $sql = "SELECT * FROM requests WHERE ID=:ID AND originalTrainer=:originalTrainer AND trainerName=:trainerName";
$stmt = $db->prepare($sql);
            $stmt->execute(array(":ID" => $ID, ":originalTrainer" => $originalTrainer, ":trainerName" => $trainerName));
            return $stmt->fetchAll(PDO::FETCH_CLASS, "requests");
        }catch(PDOException $ex) {
            echo("Could not find request.\n");
        }
    }

static public function findRequested($trainerName){
        try{
            global $db;
            $sql = "SELECT requests.* FROM(SELECT * FROM pokemon WHERE trainerName = :trainerName) AS pkmn JOIN requests ON pkmn.ID = requests.ID AND pkmn.originalTrainer = requests.originalTrainer";
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
	
public function updateStatus($newStatus){
	try{
			if($newStatus == "Accepted" or $newStatus == "Rejected"){
				
				global $db;
				$sql = "UPDATE requests SET status=:newStatus WHERE ID = :ID AND originalTrainer = :originalTrainer";
				$stmt = $db->prepare($sql);
				$stmt->execute(array(":newStatus" => $newStatus, ":ID" => $this->ID, ":originalTrainer" => $this->originalTrainer));
				return 0;
			
			}
			else{
				return -1;
			}
	
            
        }catch(PDOException $ex) {
            echo("Could not update status.\n");
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