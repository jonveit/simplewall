<?php 
	session_start();
	session_unset();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog - Logged Out </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="wrap">
	<h2> You have been logged out </h2>
	<p> Click <a href="index.php"> here </a> to log back in </p>
</div>
</body>
</html>