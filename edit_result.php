<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$pkmn=Pokemon::findByAttrs(array("ID"=>$_POST["ID"],"originalTrainer"=>$_POST["originalTrainer"]));
?>

<html>
<?php
printHead("Applying Edit");
if(count($pkmn)==1){
	$poke=$pkmn[0];
	if($poke->gettrainerName()==$_SESSION['user']->getname()){
		$attrs=changePoke($_POST,$poke);
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
function changePoke($in,$pkmn){
    $atts=array();
    foreach ($in as $key=>$value){
        if(!is_null($value) and $value != ""){
            if(in_array($key,Pokemon::getAttrs())){
				$set="set".$key;
				$suc=$pkmn->$set($value);
				if($suc==-1){
					echo "<p>Could not set ".$key.".</p>";
				}else{
					if($suc==1){
					}else{
						echo "<p>Set ".$key." to ".$value."</p>";
					}
				}
            }
        }
    }
    return $atts;
}

?>
