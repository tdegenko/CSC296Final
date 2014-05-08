<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Checking username and password</title>
<?php
require_once 'include.php';
$name=$_POST["trainerName"];
$passwd=$_POST["passwd"];
$new_session=false;
if(is_null($user)){
    echo "Checking to see if account exists\n";
    $user=users::authFindByName($name);;
    $new_session=true;
}
	if($user)
	{
        if ($new_session){
		    echo "logging in";
            if($user->verifyPasswd($passwd)){
                header('location: pokeAdd.php');
                session_start();
                $_SESSION["user"]=$user;
            }else{
                header('location: main.php');
		        echo "bad passwd";
		        echo '<meta http-equiv="refresh" content="2" URL=betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">
		        <meta name="keywords" content="automatic redirection">';
            }
        }else{
            echo "Already logged in\n";
            header('location: pokeAdd.php');
        }
	}
	else
	{
        header('location: main.php');
		echo "no such user";
		echo '<meta http-equiv="refresh" content="2" URL=betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/main.php">
		<meta name="keywords" content="automatic redirection">';
	}
?>
	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

</body>
</html>
