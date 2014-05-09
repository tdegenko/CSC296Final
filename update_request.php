<html>
<head>
<title>Updating Requests!</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<a href="pokeSearch.php">Search for a Pokemon?</a>
<a href="pokeEdit.php">Edit a Pokemon?</a>
<a href="pokeAdd.php">Add a Pokemon?</a>
<a href="requestAdd.php">Request a Pokemon?</a>
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
require_once 'include.php';

if(isset($_GET['ID'],$_GET['originalTrainer'],$_GET['action'])){
	$pkm = pokemon::findByAttrs(array("ID" => $_GET['ID'], "originalTrainer" => $_GET['originalTrainer']));
	if(count($pkm) == 1 and $pkm[0]->gettrainerName() == $_SESSION['user']->getname()){
		$req = requests::findByFDs($_GET['ID'], $_GET['originalTrainer'], $_GET['user']);
		if(count($req) == 1){
			$res = $req[0]->updateStatus($_GET['action']);
			
			if($res == 0){
				echo "request updated";
			}
			else{
				echo "could not update request";
			}
		}
		
		else{
			print_r($req);
			echo "multiple requests from same user or no requests";
		}
	}
	else{
		echo "this ain't your pokemon...biatch";
	}
}else{
	echo "invalid input";
}
?>
</body>
</html>