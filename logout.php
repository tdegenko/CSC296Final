<html>
	<head>
		<title>Logout</title>
	</head>
	<body>
<?php
require_once('include.php');
session_destroy();
?>
	<h2>You have logged out</h2>
	</body>
</html>
