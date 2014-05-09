<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$user=$_SESSION["user"]->getname();
?>

<html>
<?php
printHead("Your Pokemanz!");
?>

<?php

//print_r(requests::findMyRequests($user));
$mymanz = pokemon::findByAttrs(array("trainerName"=>$user));
foreach($mymanz as $man){
    printWrap($man);
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

function printWrap($man){
	printPoke($man);
	echo '<form method="GET" action="pokeEdit.php?">
			<input type="hidden" value="'.$man->getID().'" name="ID" />
			<input type="hidden" value="'.$man->getoriginalTrainer().'" name="originalTrainer" />
			<button>Edit</button>'.
		'</form>';
		echo '<form method="POST" action="delete.php?">
			<input type="hidden" value="'.$man->getID().'" name="ID" />
			<input type="hidden" value="'.$man->getoriginalTrainer().'" name="originalTrainer" />
			<button>Delete</button>'.
		'</form>';
}

?>