<?php	

try {
	
	$SQL = "SELECT id FROM user WHERE name = '$user' AND password = '$password'";
	$statement = $db->query($SQL);
	$num_rows = $statement->rowCount();

	if($num_rows == 1) {
		$row = $statement->fetch();
		$userid = $row['id'];
		
		$_SESSION['login'] = 1;
		$_SESSION['user'] = $user;
		$_SESSION['userid'] = $userid;
		
	} else if($num_rows > 1) {
		$userid = '';
		$errorMessage = "Error: Multiple users with the same name.  Check database.";
	} else {
		$userid = '';
		$errorMessage = "Error: No user found with that name.";
	}
	
} catch( PDOException $e )
{
	$userid = '';
	$errorMessage = "Error: " . $e->getMessage();
}

?>