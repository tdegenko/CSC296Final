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

    //from knows
    private $moveName1, $moveName2, $moveName3, $moveName4;
    
    //from species
    private $pokedex, $name, $genus, $type1, $type2, $egg_group1, $egg_group2;

    static private $public_attrs=["nickname","lvl","trainerName","happiness","HP", "attack", "defense", "specialAttack", "specialDefense", "speed", "accuracy", "evasion", "genIn"];
    static private $rattrs=["pokedex", "name", "genus", "type1", "type2", "egg_group1", "egg_group2", "ID","originalTrainer","nickname","gender","lvl","trainerName","happiness","ability","nature","shiny","HP", "attack", "defense", "specialAttack", "specialDefense", "speed", "accuracy", "evasion","pokeball","genIn","genCaught","itemName","moveName1","moveName2","moveName3","moveName4"];
    
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
    
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByAttrs($attrs){
        try{
            global $db;
    
            
            $sql = "SELECT sel.*, moveName1,moveName2,moveName3,moveName4 FROM (SELECT * FROM (SELECT pokemon.*,name,genus,type1,type2,egg_group1,egg_group2 FROM ";
            $sql .= "pokemon JOIN species on pokemon.pokedex=species.pokedex) AS inst ";
            $where="WHERE ";
            $any=false;
            $params=array();
            foreach ($attrs as $key=>$value){
                if(in_array($key,self::$rattrs)){
                    if($any){
                        $where.=" AND ";
                    }
                    $where.=$key."=:".$key;
                    $params[":".$key]=$value;
                    $any=true;
                }
            }
            
            if ($any) {
                $sql.=$where;
            }
            $sql.=") AS sel JOIN knows ON sel.ID=knows.pokemonID AND sel.originalTrainer=knows.originalTrainer;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Pokemon");
        }catch(PDOException $ex) {
            echo("Could not find requested pokemon.\n");
        }
    }
}
//$tmp=pokemon::findByPokename("Ho-Oh")[0];
//$tmp=pokemon::findByAttrs(array("name"=>"Ho-Oh"))[0];
//print_r($tmp);
//echo $tmp->getname();
