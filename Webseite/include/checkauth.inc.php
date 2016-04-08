<?php
session_start();

if(!isset($_SESSION['user_id'])) 
{	
	$page = "page=".$_SERVER['PHP_SELF'];
	$id = "";
	
	if(isset($_REQUEST["id"]))
	{	
		$id = "&id=".$_REQUEST["id"];
	}
	
	$navbar = 3;
	include ('include/navigation.inc.php');
	
	echo '<div class="container">';
		header('Refresh: 1; URL = login.php?'.$page.$id);
		die('<h2>Sie sind nicht eingeloggt.</h2> Bitte <a href="login.php">melden</a> Sie sich an.');
	echo '</div>';
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['user_id'];
$userNachname = $_SESSION['user_nachname'];
$userVorname = $_SESSION['user_vorname'];

if($_SESSION['user_role'] == '1') 
{
	$navbar = 1;	
}

if($_SESSION['user_role'] == '2') 
{
	$navbar = 2;
}
?>