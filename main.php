<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	
</head>
<body>
	
<div id="header-wrap">
	<div id="header">
		<h2>SimpleWall for <?php echo ucwords($user); ?></h2>
		<button id="logout" onclick="location.href='logout.php'">Logout</button>
		<button id="display" onclick="location.href='display.php?user=<?php echo $user; ?>'">Display</button>
	</div>
</div>
	
<div id="wrap">
	<form id="addpost" autocomplete="off">
		<input type="text" name="new-url" placeholder="enter a url..." id="newurl_field">
		<input type="submit" value="Add">
	</form>
	
	<ul id="postfeed">
	</ul>	
</div>

	<script src="//code.jquery.com/jquery-latest.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script src="simplewall.js"></script>

</body>
</html>

