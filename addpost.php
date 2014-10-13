<?php

require_once "config.php";
require_once "FirePHP.class.php";

$firephp = FirePHP::getInstance(true); 

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

// First Step is to Grab the Data from the URL
////

$url = $_GET['url'];
$firephp->log($url);

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$html = file_get_contents_curl($url);

//parsing begins here:
$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

$title = '';
$description = '';


//get and display what you need:
$title = $nodes->item(0)->nodeValue;

$metas = $doc->getElementsByTagName('meta');

for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('name') == 'description' or
		$meta->getAttribute('property') == 'og:description')
        $description = $meta->getAttribute('content');
	if($meta->getAttribute('property') == 'og:image')
		$imageurl = $meta->getAttribute('content');
	if($meta->getAttribute('property') == 'og:title')
		$title = $meta->getAttribute('content');
    if($meta->getAttribute('name') == 'keywords')
        $keywords = $meta->getAttribute('content');
}

try {
	$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, 
	array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$userid = $_SESSION['userid'];
	$date = date('l, F j, Y');
	
	$SQL = "INSERT INTO news (_f_user,title,url,description,date) VALUES (:userid,:title,:url,:description,:now)";

	$q = $db->prepare($SQL);
	$affected_rows = $q->execute(array(':userid'=>$userid,':title'=>$title, ':url'=>$url, ':description'=>$description, ':now'=>$date));
	
	$postid = $db->lastInsertId();
	
	$SQL = "INSERT INTO image (_f_post,url) VALUES (:postid,:imageurl)";

	$q = $db->prepare($SQL);
	$affected_rows = $q->execute(array(':postid'=>$postid, ':imageurl'=>$imageurl));

} catch(PDOException $e) {
	echo $e->getMessage();
}