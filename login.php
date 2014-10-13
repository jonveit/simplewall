<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Blog </title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div id="login">
	
	<form name="login" action="index.php" method="POST">
		<h2> Blog </h2>
		<input type="text" name="user" value="" placeholder="Username">
		<input type="password" name="password" value="" placeholder="Password">
		<input type="submit" value="Login">
	</form>
	
	<div id="errorMessages"> <?php echo $errorMessage; ?> </div>
</div>

</body>
</html>