<?php 
class Moves{
    private $name, $element, $typ, $pwr, $accuracy, $PP, $contest;
    static private $rattrs=array("name", "element", "typ", "pwr", "accuracy", "PP", "contest");
    
    //generic getter/setter method
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
            $sql .= "moves ";
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
            $where.=";";
            
            if ($any) {
                $sql.=$where;
            }
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Moves");
        }catch(PDOException $ex) {
            echo("Could not find requested pokemon.\n");
        }
    }
}
?>
