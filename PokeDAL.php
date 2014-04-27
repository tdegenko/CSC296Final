<?php

/*
* PokeDAL.php - Data Abstraction Layer for PokeTrade database
* 
*/

require_once 'dbsetup.php';


//  private $address, $contact;
    


class Pokemon{

    //from pokemon
    private $ID, $originalTrainer, $nickname, $gender, $lvl, $trainerName, 
    $happiness, $ability, $nature, $shiny,  $HP, $attack, $defense, $specialAttack, $specialDefense, $speed, $accuracy, $evasion, $pokeball, $genIn, $genCaught;

    //from species
    private $pokedex, $name, $genus, $type1, $type2, $egg_group1, $egg_group2;

    //generic getter method
    function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }
    }
    
    //a more generic approach: pass an array of attributes
    //and add conditions to the query based on these attributes
    static public function findByAttrs($attrs){
        try{
            global $db;
    
            
            $sql = "SELECT * FROM ";
            $sql .= "pokemon JOIN species ";
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
                if($key=="genIn"){
                    if($any){
                        $where.="AND ";
                    }
                    $where.="genIn=:genIn ";
                    $params[":genIn"]=$value;
                    $any=true;
                }
                if($key=="genCaught"){
                    if($any){
                        $where.="AND ";
                    }
                    $where.="genCaught=:genCaught ";
                    $params[":genCaught"]=$value;
                    $any=true;
                }
            }
            $where.=";";
            
            if ($any) {
                $sql.=$where;
            }
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
