<?php

/*
* ItemDAL.php - Data Abstraction Layer for Item database
*
*/

require_once 'dbsetup.php';


class Item{

    //from Item
    private $name, $effect;
    
    //generic getter
     function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }
    }
	
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByName($attrs){
        try{
            global $db;
    
            
            $sql = "SELECT * FROM ";
            $sql .= "items ";
            $where="WHERE ";
            $any=false;
            $params=array();
            foreach ($attrs as $key=>$value){
                if($key=="name"){
                    if($any){
                        $where.="AND ";
                    }
                    $where.="name=:name ";
                    $params[":name"]=$value;
                    $any=true;
                }
               
            }
            $where.=";";
            
            if ($any) {
                $sql.=$where;
            }
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Item");
        }catch(PDOException $ex) {
            echo("Could not find requested Item.\n");
        }
    }
    
    
}
