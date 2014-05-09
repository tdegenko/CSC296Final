<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$attrs=mapToAttrs($_POST);
$pkmn=Pokemon::findByAttrs($attrs);
$user=$_SESSION["user"]->getname();
?>

<html>
<head>
<title>PokeTrader</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<a href="pokeSearch.php">Search for another Pokemon?</a>
<a href="pokeEdit.php">Edit a Pokemon?</a>
<a href="pokeAdd.php">Add a Pokemon?</a>
<a href="yourRequests.php">Look at your requests?</a> 
<style>
table{
border-collapse:collapse;
}
table, th, td{
border: 1px solid black;
}
</style>
</head>

<body>
<h2><?=count($pkmn);?> Results</h2>

<?php
foreach($pkmn as $poke){
    printPoke($poke);
	echo '<form action="req.php" method="POST">
		<input type="hidden" value="'.$_SESSION["user"]->getname().'" name="trainerName" />
		<input type="hidden" value="'.$pok->getID().'" name="ID" />
		<input type="hidden" value="'.$pok->getoriginalTrainer().'" name="originalTrainer" />
		<input type="submit" value="Request Pokemon" />
	</form>';
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
