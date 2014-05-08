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

