<?php
	$user = $_GET['user'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="display">
		<ul id="blogfeed">
				<?php include "displayposts.php" ?>
		</ul>
	</div>
</body>
</html>