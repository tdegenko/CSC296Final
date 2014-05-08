<?php

/*
* PokeDAL.php - Data Abstraction Layer for PokeTrade database
* 
*/

require_once 'dbsetup.php';
require_once 'ItemDAL.php';
require_once 'MovesDAL.php';


//  private $address, $contact;
    


class Pokemon{

    //from pokemon
    private $ID, $originalTrainer, $nickname, $gender, $lvl, $trainerName, 
    $happiness, $ability, $nature, $shiny,  $HP, $attack, $defense, $specialAttack, $specialDefense, $speed, $accuracy, $evasion, $pokeball, $genIn, $genCaught, $itemName;
    
    static private $poke_attrs=array("ID", "originalTrainer", "nickname", "gender", "lvl", "trainerName", "happiness", "ability", "nature", "shiny", "HP", "attack", "defense", "specialAttack", "specialDefense", "speed", "pokeball", "genIn", "genCaught", "pokedex", "itemName");

    //from knows
    private $moveName1, $moveName2, $moveName3, $moveName4;
    
    //from species
    private $pokedex, $name, $genus, $type1, $type2, $egg_group1, $egg_group2;

    static private $public_attrs=array("nickname","lvl","trainerName","happiness","HP", "attack", "defense", "specialAttack", "specialDefense", "speed","genIn");
    static private $rattrs=array("pokedex", "name", "genus", "type1", "type2", "egg_group1", "egg_group2", "ID","originalTrainer","nickname","gender","lvl","trainerName","happiness","ability","nature","shiny","HP", "attack", "defense", "specialAttack", "specialDefense", "speed","pokeball","genIn","genCaught","itemName","moveName1","moveName2","moveName3","moveName4");
    static private $type_rattrs=array("type1","type2");
    static private $egg_rattrs=array("egg_group1","egg_group2");
    static private $move_rattrs=array("moveName1","moveName2","moveName3","moveName4");
    
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
                    $sql =  "UPDATE pokemon
                             SET :attr=:val
                             WHERE originalTrainer=:ot AND ID=:id;"; 
                    $stmt = $db->prepare($sql);
                    $params = array(
                        ":attr" => $var,
                        ":val"  => $this->$var,
                        ":ot"   => $this->originalTrainer,
                        ":id"   => $this->ID
                    );
                    $stmt->execute($params);
                }catch(PDOException $ex) {
                    echo("Could not update requested pokemon.\n");
                }
                
            }else{
                return -1;
            }
        }
    }
	
	static public function getRAttrs(){
        return self::$rattrs;
    }
    //constructs a new pokemon and trys to write it to the DB. if it succeds returns the pokemon otherwise returns false;
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
            $sql="INSERT INTO pokemon(
                    ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP,
                    attack, defense, specialAttack,specialDefense, speed, originalTrainer, 
                    pokeball, genIn, genCaught, trainerName, pokedex, itemName) ".
            "VALUES (
                    :ID, :nickname, :gender, :lvl, :happiness, :ability, :nature, :shiny, :HP,
                    :attack, :defense, :specialAttack, :specialDefense, :speed, :originalTrainer, 
                    :pokeball, :genIn, :genCaught, :trainerName, :pokedex, :itemName
            ); ";
            $params=array();
            foreach(self::$poke_attrs as $key){
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
            $sql="INSERT INTO knows 
            (ID, originalTrainer, moveName1, moveName2,moveName3,moveName4) ".
            "VALUES (:ID, :originalTrainer, :moveName1, :moveName2, :moveName3, :moveName4);";
            $params=array(
                ":ID"=>$this->ID,
                ":originalTrainer"=>$this->originalTrainer
            );
            foreach(self::$move_rattrs as $key){
                $params[$key]=$this->$key;
            }
            $stmt = $db->prepare($sql);
            if(!$stmt){
                $db->rollBack();
                $error = "Could not add known moves";
                throw new Exception($error);
            }
            if(!$stmt->execute($params)){
                $db->rollBack();
                $error = "Could not add known moves";
                throw new Exception($error);
            }
            $db->commit();
        }catch(PDOException $ex) {
            echo("Could not find requested pokemon.\n");
        }
        

    }
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByAttrs($attrs){
        try{
            global $db;
    
            
            $sql = "SELECT sel.*, moveName1,moveName2,moveName3,moveName4 FROM (SELECT * FROM (SELECT pokemon.*,name,genus,type1,type2,egg_group1,egg_group2 FROM ";
            $sql .= "pokemon LEFT JOIN species on pokemon.pokedex=species.pokedex) AS inst ";
            $where="WHERE ";
            $any=false;
            $params=array();
            foreach ($attrs as $key=>$value){
                if(in_array($key,self::$rattrs) and !(in_array($key,self::$move_rattrs)) and (!is_null($value)) and $value !=""){
                    if($any){
                        $where.=" AND ";
                    }
                    if(in_array($key,self::$type_rattrs)){
                        $where.="(";
                        $first=true;
                        foreach(self::$type_rattrs as $rkey){
                            if(!$first){
                                $where.=" OR ";
                            }else{
                                $first=false;
                            }
                            $where.=$rkey."=:".$key;
                            $params[":".$key]=$value;
                        }
                        $where.=")";
                    }elseif(in_array($key,self::$egg_rattrs)){
                        $where.="(";
                        $first=true;
                        foreach(self::$egg_rattrs as $rkey){
                            if(!$first){
                                $where.=" OR ";
                            }else{
                                $first=false;
                            }
                            $where.=$rkey."=:".$key;
                            $params[":".$key]=$value;
                        }
                        $where.=")";
                    }else{
                        $where.=$key."=:".$key;
                        $params[":".$key]=$value;
                    }
                    $any=true;
                }
            }
            
            if ($any) {
                $sql.=$where;
            }
            $sql.=") AS sel JOIN knows ON sel.ID=knows.ID AND sel.originalTrainer=knows.originalTrainer ";
            $where="WHERE ";
            $any=false;
            foreach ($attrs as $key=>$value){
                if(in_array($key,self::$rattrs) and (in_array($key,self::$move_rattrs)) and (!is_null($value)) and $value !=""){
                    if($any){
                        $where.=" AND ";
                    }
                    if(in_array($key,self::$move_rattrs)){
                        $where.="(";
                        $first=true;
                        foreach(self::$move_rattrs as $rkey){
                            if(!$first){
                                $where.=" OR ";
                            }else{
                                $first=false;
                            }
                            $where.=$rkey."=:".$key;
                            $params[":".$key]=$value;
                        }
                        $where.=")";
                    }
                    $any=true;
                }
            }
            
            if ($any) {
                $sql.=$where;
            }
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Pokemon",array(NULL));
        }catch(PDOException $ex) {
            echo("Could not find requested pokemon.\n");
        }
    }
}
//$tmp=pokemon::findByPokename("Ho-Oh")[0];
//$tmp=pokemon::findByAttrs(array("name"=>"Ho-Oh"))[0];
//print_r($tmp);
//echo $tmp->getname();
