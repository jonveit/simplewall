<?php 

require_once "lib/FirePHP.class.php";

$firephp = FirePHP::getInstance(true);
$errorMessage = '';

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] != '')
{
	require_once "config.php";
	require_once "dbaccess.php";
	
	$user = $_SESSION['user'];
	$userid = $_SESSION['userid'];

	if($db && $userid != '') {
		include "main.php";
	} else {
		include "login.php";
	}
	
} else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user']) && isset($_POST['password'])) {
	
	require_once "config.php";
	require_once "dbaccess.php";
	
	$user = $_POST['user'];
	$password = $_POST['password'];
	
	require_once "login_user.php";
	
	if($db && $userid != '') {
		include "main.php";
	} else {
		include "login.php";
	}

} else {
	include "login.php";
}

?>
