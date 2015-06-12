<?php
session_start();
require_once 'class/Shortener.php';

$s = new Shortener;

if(isset($_POST['url'])){
	$url = $_POST['url'];

	if ($code = $s->makeCode($url)){
		$_SESSION['feedback'] = "Generated! Your short URL is: <a href=\"http://localhost:8080/phpProject/{$code}\">http://localhost:8080/phpProject/{$code}</a>";
	} else{
		$_SESSION['feedback'] = "There was a problem. Invalid URL";
	}
}

header('Location: index.php');