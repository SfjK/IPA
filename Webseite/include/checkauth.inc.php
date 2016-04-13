<?php
/**
 * Start session
 */
session_start();

/**
 * if session does not exist, get url, redirect to login and wirte the old url to the login url
 */
if(!isset($_SESSION['user_id'])) 
{	
	/**
	 * get page and if it exists, the id
	 * 
	 * @var string $page - get the page
	 * @var integer $id - get id if exists
	 */
	$page = "page=".$_SERVER['PHP_SELF'];
	$id = "";
	if(isset($_REQUEST["id"]))
	{	
		$id = "&id=".$_REQUEST["id"];
	}
	
	/**
	 * get navbar
	 * @var integer $navbar - navbar version
	 */
	$navbar = 3;
	include ('include/navigation.inc.php');
	
	/**
	 *	html structure
	 */
	echo '<div class="container">';
		header('Refresh: 1; URL = login.php?'.$page.$id);
		die('<h2>Sie sind nicht eingeloggt.</h2> Bitte <a href="login.php">melden</a> Sie sich an.');
	echo '</div>';
}

/**
 * get id, vorname and nachname from session for navigation
 */
$userid = $_SESSION['user_id'];
$userNachname = $_SESSION['user_nachname'];
$userVorname = $_SESSION['user_vorname'];

/**
 * change navbar dependent on userrole
 */
if($_SESSION['user_role'] == '1') 
{
	$navbar = 1;	
}
if($_SESSION['user_role'] == '2') 
{
	$navbar = 2;
}
?>