<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$user=$_SESSION["user"]->getname();
?>

<html>
<head>
<title>Your Requests!</title>

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
<h2>Your Requests</h2>

<?php

print_r(requests::findMyRequests($user));

?>

<h3>Requested of you</h3>
<?php

print_r(requests::findRequested($user));

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