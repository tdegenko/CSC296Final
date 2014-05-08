<?php
//to do:use variables when DAL is complete
require_once 'RequestsDAL.php';
$attrs=mapToAttrs($_POST);
$pkmn=Pokemon::findByAttrs($attrs);
?>

<html>
<head>
<title>Add Request</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<a href="pokeAdd.php">Add another request?</a>
<a href="pokeEdit.php">Edit a Pokemon?</a>
<a href="pokeSearch.php">Search for a Pokemon?</a>
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
	if($pkmn)
		$req=new Requests($attrs);
?>
<h2>Request Added</h2>

<?php
} catch (Exception $e) {
    echo 'Could not add request';
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