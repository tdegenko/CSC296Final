<?php
//to do:use variables when DAL is complete
require_once ('include.php');
$attrs=mapToAttrs($_POST);
$pkmn=Pokemon::findByAttrs($attrs);
?>

<html>
<?php
printHead("Deleting Pokemon");
if(count($pkmn)==1){
	$poke=$pkmn[0];
	if($poke->gettrainerName()==$_SESSION['user']->getname()){
		if($poke->delete()==0){
			echo "<h2>Deleted</h2>";
		}else{
			echo '<h2>Could not delete pokemon</h2>';
		}
		printPoke($poke);
	}else{
		echo "<h2>Not your Pokemon... tsk,tsk...</h2>";
	}
}else{
?>
		<h2>No uniquely identified pokemon</h2>
<?php
}
?>
    </body>
</html>
<?php
function mapToAttrs($in){
    $atts=array();
    foreach ($in as $key=>$value){
        if(!is_null($value) and $value != ""){
            if(in_array($key,Pokemon::getRAttrs())){
                $atts[$key]=$value;
            }
        }
    }
    return $atts;
}
?>
