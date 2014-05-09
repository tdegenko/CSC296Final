<?php
//to do:use variables when DAL is complete
require_once ('include.php');
?>

<html>

<?php
printHead("Requesting Pokemon");
try{
?>
    <h2>Pokemon Requested</h2>

<?php
   addRequest($_POST["ID"],$_POST["originalTrainer"],$_POST["trainerName"]);
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