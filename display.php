<?php
	$user = $_GET['user'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog </title>
	<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="david.css">
</head>
<body>
	<div id="displayfeed">
		<ul id="postfeed">
				<?php include "displayposts.php" ?>
		</ul>
	</div>
</body>
</html>