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

    private $public_attrs=["nickname","lvl","trainerName","happiness","HP", "attack", "defense", "specialAttack", "specialDefense", "speed", "accuracy", "evasion", "genIn"];
    
    //generic getter/setter method
    function __call($method, $params){
        $var = substr($method,3);
        if(strncasecmp($method,"get",3)==0){
            return $this->$var;
        }
        if(strncasecmp($method,"set",3)==0){
            if(in_array($var,$public_atttrs) and count($params)=1){
                try{
                    $this->$var=$params[0];
                    $sql =  "UPDATE pokemon
                             SET :attr=:val
                             WHERE originalTrainer=:ot AND ID=:id;"  
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
