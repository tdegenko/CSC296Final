<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Checking username and password</title>
<?php
//require_once 'include.php';
require_once('UserDAL.php');
$name=$_POST["trainerName"];
$passwd=$_POST["passwd"];
echo "Checking to see if account exists\n";
$user=users::authFindByName($name);
if($user)
{
    session_start();
    echo "logging in";
    if($user->verifyPasswd($passwd)){
        header('location: pokeAdd.php');
        $_SESSION["user"]=$user;
    }else{
#        header('location: main.php');
        echo "bad passwd";
#        echo '<meta http-equiv="refresh" content="2" URL=betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">
#        <meta name="keywords" content="automatic redirection">';
    }
}
else
{
//        header('location: main.php');
	echo "no such user";
#	echo '<meta http-equiv="refresh" content="2" URL=betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">
#	<meta name="keywords" content="automatic redirection">';
}
?>
	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

</body>
</html>
