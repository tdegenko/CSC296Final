<?php
//to do:use variables when DAL is complete
require_once 'UserDAL.php';
$attrs=mapToAttrs($_POST);
?>

<html>
    <head>
    <title>PokeTrader New User</title>
	<meta http-equiv="refresh" content="2; URL=betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">
	<meta name="keywords" content="automatic redirection">
	<a href="betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">click to return to main if browser doesn't redirect you</a>
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
    $user=new User($attrs);
?>
    <h2>User Added</h2>

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