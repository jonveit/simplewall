<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

