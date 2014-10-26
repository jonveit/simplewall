<?php

require_once "FirePHP.class.php";
$firephp = FirePHP::getInstance(true);

// Only allow if logged in ******************

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

// First Step is to Grab the Data from the URL ********

$url = $_POST['url'];

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

if(!isset($imageurl)) {
	$imageurl = "default.png";
}

// Second Step is to add new information to the database ******

try {
	
	require_once "config.php";
	require_once "dbaccess.php";
	
	$date = date('l, F j, Y');
	$userid = $_SESSION['userid'];
	
	$SQL = "SELECT MIN(_z_order) AS old_index FROM post WHERE _f_user = '$userid'";
	$statement = $db->query($SQL);
	$row = $statement->fetch();
	$old_index = $row['old_index'];
	
	if($old_index == NULL) {
		$new_index = 100;	
	} else {
		$new_index = $old_index - 1;
	}

	$SQL = "INSERT INTO post(_f_user,title,url,description,postdate,_z_order) VALUES(:userid,:title,:url,:description,:now,:new_index)";
	$statement = $db->prepare($SQL);
	$affected_rows = $statement->execute(array(':userid'=>$userid,':title'=>$title, ':url'=>$url, ':description'=>$description, ':now'=>$date, ':new_index'=>$new_index));
	
	$postid = $db->lastInsertId();
	
	$SQL = "INSERT INTO image (_f_post,url) VALUES (:postid,:imageurl)";
	$q = $db->prepare($SQL);
	$affected_rows = $q->execute(array(':postid'=>$postid, ':imageurl'=>$imageurl));

} catch(PDOException $e) {
	return $e->getMessage();
}