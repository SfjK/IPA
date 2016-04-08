<?php
if($_SESSION['user_role']!= 1)
{
	$navbar = 3;
	include ('include/navigation.inc.php');
	echo '<div class="container">';
	header('Refresh: 2; URL = index.php');
	die('<h2>Keine Berechtigung für diese Seite</h2> Bitte <a href="index.php">melden</a> Sie sich an.');
	echo '</div>';
}
?>