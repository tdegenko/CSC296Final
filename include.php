<?php
//include EVERYTHING!
require_once("PokeDAL.php");
require_once("ItemDAL.php");
require_once("MovesDAL.php");
require_once("RequestsDAL.php");
require_once("UserDAL.php");
session_start();
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}else{
    session_destroy();
    $user=NULL;
    header('location: main.php');
}
function printHead($page){
?>
<head>
<title><?=$page?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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
<a href="pokeSearch.php">Search for a Pokemon?</a>
<a href="myPoke.php">Edit/Delete a Pokemon?</a>
<a href="pokeAdd.php">Add a Pokemon?</a>
<a href="yourRequests.php">Look at your requests?</a>
<h2><?=$page?></h2>
<?php
}
?>

