<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$attrs=mapToAttrs($_POST);
?>

<html>
    <head>
    <title>PokeTrader New User</title>
	<meta http-equiv="refresh" content="2" URL="main.php">
	<meta name="keywords" content="automatic redirection">
	<a href="main.php">click to return to main if browser doesn't redirect you</a>
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
<?php
try{
    $user=new users($attrs);
?>
    <h2>User Added</h2>
<?php
}catch(Exception $e){
?>
    <h2>Failed to add user <h2>
<?php
}
?>
    </body>
</html>
<?php
function mapToAttrs($in){
    $atts=array();
    foreach ($in as $key=>$value){
        if(!is_null($value) and $value != ""){
            if(in_array($key,User::getRAttrs())){
                $atts[$key]=$value;
            }
        }
    }
    return $atts;
}
?>
