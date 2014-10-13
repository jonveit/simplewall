<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true);

session_start();

///
// Arriving at the page already logged in and user set.
///
if (isset($_SESSION['login']) && $_SESSION['login'] != '' && isset($_SESSION['user'])) {
	
	try {
		
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$user = $_SESSION['user'];	
		
	include 'main.php';
	
	} catch(PDOException $e) { 
		$errorMessage = $e->getMessage(); 
		include 'login.php';
	}
} 
///
// Arriving at the page with a request to log in
///
else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user']) && isset($_POST['password'])) {
	
	try {
		$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
		array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));	

		$user = $_POST['user'];
		$password = $_POST['password'];

		$SQL = "SELECT * FROM user WHERE name = '$user'";
		$result = $db->query($SQL);
		$row = $result->fetch();
	
		if(!($row)) {
			$errorMessage = "Error: User not found!";
			include "login.php";
		} else if($row['password'] != $password){
			$errorMessage = "Error: User found but password not correct!";
			include "login.php";
		} else {
			$_SESSION['login'] = "1";
			$_SESSION['user'] = $user;
			$_SESSION['userid'] = $row['id'];
			include "main.php";
		}
	} catch(PDOException $e) { 
		$errorMessage = $e->getMessage(); 
		include 'login.php';
	}
} 
// First time visiting, user not logged in, post request not being made
else {
	include 'login.php';
}
	
?>