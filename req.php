<?php
//to do:use variables when DAL is complete
require_once ('include.php');
?>

<html>
    <head>
    <title>PokeRequest</title>
	
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<a href="pokeAdd.php">Add/delete another Pokemon?</a> 
	<a href="pokeEdit.php">Edit a Pokemon?</a> 
	<a href="pokeSearch.php">Search for a Pokemon?</a> 
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
<?php
try{
	printPoke($pkmn);
?>
    <h2>Pokemon Requested</h2>

<?php
   addRequest($_POST["ID"],$_POST["originalTrainer"],$_POST["trainerName"],);
} catch (Exception $e) {
    echo 'Could not request pokemon';
}
?>
    </body>
</html>
<?php
function addRequest($ID, $originalTrainer, $trainerName){
	new Requests(array("ID"=>$ID,"originalTrainer"=>$originalTrainer,"trainerName"=>$trainerName));
	echo "request accepted!";
}
?>