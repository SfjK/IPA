<?php
function toSha($hp)
{
	$hashpasswort = hash('sha512', $hp);
	return $hashpasswort;
}

function logOut()
{
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	header('Refresh: 1; URL = login.php');

	echo '<div class="container">';
		echo '<h2>Logout</h2>';
		echo '<p>Sie werden ausgeloggt</p>';
	echo '</div>';
}
?>
