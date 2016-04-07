<?php
	include ('include/dbsettings.inc.php');
	$conn = @mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) 
	{
		echo '<nav class="navbar navbar-default navbar-fixed-top">';
			echo '<div class="container-fluid">';
				echo '<div class="navbar-header">';
					echo '<form role="form">';
						echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">';
							echo '<span class="icon-bar"></span>';
							echo '<span class="icon-bar"></span>';
							echo '<span class="icon-bar"></span>';
						echo '</button>';
					echo '</form>';
					echo '<a href="/login.php"><img src="logo/swissbanking_logo_183_27.png" alt="Swissbanking" /></a>';
				echo '</div>';
				echo '<div class="collapse navbar-collapse" id="myNavbar">';
					echo '<ul class="nav navbar-nav navbar-right">';
						echo '<li>';
							echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span> Hilfe</a>';
						echo '</li>';
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo '</nav>';
		echo '<div class="alert alert-danger">';
			echo '<p><strong>Fehler:</strong> Es konnte keine Verbindung zur Datenbank hergestellt werden. '.mysqli_connect_error().'</p>';
		echo '</div>';
		die;
	}
	// echo "Datenbank erfolgreich verbunden";
?>