<?php
/** variables */
$title = "TSW │ Profil";
$header = "normal";
$navbar = 1;

$validationError = "";
$error = 0;

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/checkauth.inc.php');

/** post-back for profile */
if(isset($_POST['update-profile']))
{
	$tempVorname = $_POST["vorname"];
	$tempNachname = $_POST["nachname"];
	$userEmail= $_POST["email"];
	$userPhone = $_POST["phone"];
	$userMobile = $_POST["mobile"];
	$userPasswort = $_POST["passwort"];
	
	$validationError = "";
	$error = 0;
	
	$tempVorname = strip_tags($tempVorname);
	$tempNachname = strip_tags($tempNachname);
	$userEmail = strip_tags($userEmail);
	$userPhone = strip_tags($userPhone);
	$userMobile = strip_tags($userMobile);
	
	/** validation */
	$validationError = validateUser($conn, $tempVorname, $tempNachname,"", $userPhone, $userMobile, $userEmail, $userid, $validationError);
	if (!empty($validationError))
	{
		$validationError = '<div class="alert alert-danger">'.$validationError.'</div>';
	}
	
	if (empty($validationError))
	{
		$userNachname = $tempNachname;
		$userVorname = $tempVorname;
		$_SESSION["user_nachname"] = $userNachname;
		$_SESSION["user_vorname"] = $userVorname;
		
		if (empty($userPasswort))
		{
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?, cEmail=?, cPhone=?, cMobile=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "sssssi", $userVorname, $userNachname, $userEmail, $userPhone, $userMobile, $userid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		else 
		{
			$userPasswort = toSha($userPasswort);
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?, cEmail=?, cPhone=?, cMobile=? ,cPasswort=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "ssssssi", $userVorname, $userNachname, $userEmail, $userPhone, $userMobile, $userPasswort, $userid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}	
}

include ('include/navigation.inc.php');	
	
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cBenutzerID=?"))
{
	mysqli_stmt_bind_param($stmt, "i", $userid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
		
	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		mysqli_fetch_array($result, MYSQLI_NUM);

		foreach ($result as $row)
		{
			$pVorname = $row["cVorname"];
			$pNachname = $row["cNachname"];
			$pEmail= $row["cEmail"];
			$pPhone = $row["cPhone"];
			$pMobile = $row["cMobile"];
		}

		echo '<div class="container">';
			echo '<form class="form-horizontal" role="form" method="post" autocomplete="off">';
				echo '<input type="text" style="display: none" id="fakeUsername" name="fakeUsername" value=""/>';
				echo '<input type="password" style="display: none" id="fakePassword" name="fakePassword" value=""/>';
				echo '<div class="form-group">';
					echo '<h2 class="col-md-4 control-label" >Profil</h2>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Vorname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="vorname" value="';
							echo $pVorname;
						echo'"type="text" autofocus>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Nachname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="nachname" value="';
							echo $pNachname;
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">E-Mail Adresse *</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="email" value="';
							echo $pEmail;
						echo'"type="text" required>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Telephonnummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="phone" value="';
							echo $pPhone;
						echo'"type="text" placeholder="0041000000000">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Handynummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="mobile" value="';
							echo $pMobile;
						echo'"type="text" placeholder="0041000000000">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label"></label>';
					echo '<div class="col-md-4 control-txt">';
						echo 'Passwort ändern:';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Neues Passwort</label>';
					echo '<div class="col-md-4">';
						echo '<input type="password" class="form-control" name="passwort" id="focusedInput" value=""';
						echo'type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label"></label>';
					echo '<div class="col-md-2">';
						echo '<button class="btn btn-primary btn-block" type="submit" name="update-profile">Speichern</button>';
					echo '</div>';
					echo '<div class="col-md-2">';
						echo '<a class="btn btn-default btn-block" href="index.php" role="button">Zurück</a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<label class="col-md-2 control-label"></label>';
					echo '<div class="col-md-4">';
						echo $validationError;
					echo '</div>';
				echo '</div>';
			echo '</form>';
		echo '</div>';
	}
	else
	{
		echo '<div class="container"><div class="alert alert-danger"><strong>Error: </strong>Dieser User existiert nicht.</div></div>';
	}
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
}

/** includes */
include ('include/footer.inc.php');
?>