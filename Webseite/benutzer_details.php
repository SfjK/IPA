<?php
/** Variables */
$title = "TSW │ Benutzerdetail";
$header = "normal";
$navbar = 1;

$validationError = "";
$error = 0;

/** Includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/checkauth.inc.php');
include ('include/checkrole.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');

$detailId = $_GET['id'];

if(isset($_POST['delete-user']))
{
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "DELETE FROM tbenutzer WHERE cBenutzerID=?");
	mysqli_stmt_bind_param($stmt, "i", $detailId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
	header('Location: usermanagement.php');
}

if(isset($_POST['save-user']))
{
	$userVorname = $_POST["vorname"];
	$userNachname = $_POST["nachname"];
	$userName = $_POST["username"];
	$userEmail= $_POST["email"];
	$userPhone = $_POST["phone"];
	$userMobile = $_POST["mobile"];
	$userPasswort = $_POST["passwort"];
	$userRolle = $_POST["rolle"];
	
	$userVorname = strip_tags($userVorname);
	$userNachname = strip_tags($userNachname);
	$userName = strip_tags($userName);
	$userEmail= strip_tags($userEmail);
	$userPhone = strip_tags($userPhone);
	$userMobile = strip_tags($userMobile);
	
	if (mb_strlen($userVorname, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Vorname ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($userNachname, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Nachname ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($userName, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Username ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($userEmail, 'utf8')  > 255)
	{
		$validationError .= "Fehler: Die E-Mail-Adresse ist zu lang. Er darf maximal 255 Zeichen enthalten.";
		$error = 1;
	}
	if ($userPhone != 0)
	{
		if(!preg_match("/^[0-9]{13}$/", $userPhone))
		{
			$validationError .= "Fehler: Geben Sie eine gültige Telefon-Nummer ein.";
			$error = 1;
		}
	}
	if ($userMobile != 0)
	{
		if(!preg_match("/^[0-9]{13}$/", $userMobile))
		{
			$validationError .= "Fehler: Geben Sie eine gültige Mobiltelefon-Nummer ein.";
			$error = 1;
		}
	}
	if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
		$validationError .= "Fehler: Geben Sie eine gültige E-mail Adresse an ein.";
		$error = 1;
	}
	
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cEmail=? && cBenutzerID!=?");
	mysqli_stmt_bind_param($stmt, "ss", $userEmail, $detailId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		$validationError .= "Fehler: Die angegebene E-mail wird bereits wird bereits verwendet. Bitte geben Sie eine andere an.";
		$error = 1;
	}
	mysqli_stmt_close($stmt);
	
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=? && cBenutzerID!=?");
	mysqli_stmt_bind_param($stmt, "ss", $userName, $detailId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		$validationError .= "Fehler: Es existiert bereits ein User mit diesem Username. Nutzen Sie bitte einen anderen.";
		$error = 1;
	}
	mysqli_stmt_close($stmt);
	
	if ($error == 0)
	{
		$_SESSION["user_nachname"] = $userNachname;
		$_SESSION["user_vorname"] = $userVorname;
		
		if ($userPasswort === "")
		{
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?, cEmail=?, cPhone=?, cMobile=? ,cRolle=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "sssssii", $userVorname, $userNachname, $userEmail, $userPhone, $userMobile,$userRolle, $detailId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		else
		{
			$userPasswort = toSha($userPasswort);
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?, cEmail=?, cPhone=?, cMobile=? ,cPasswort=?,cRolle=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "ssssssi", $userVorname, $userNachname, $userEmail, $userPhone, $userMobile, $userPasswort ,$userRolle, $detailId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		if ($_SESSION["user_id"] == $detailId)
		{
			$_SESSION["user_username"] = $userName;
			$_SESSION["user_nachname"] = $userNachname;
			$_SESSION["user_vorname"] = $userVorname;
			$_SESSION["user_role"] = $userRolle;
		}
	}
}

$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer Where cBenutzerID=?"))
{
	mysqli_stmt_bind_param($stmt, "i", $detailId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		mysqli_stmt_bind_param($stmt, "i", $detailId);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		mysqli_fetch_array($result, MYSQLI_NUM);

		foreach ($result as $row)
		{
			$pID = $row["cBenutzerID"];
			$pVorname = $row["cVorname"];
			$pNachname= $row["cNachname"];
			$pUsername = $row["cUsername"];
			$pEmail= $row["cEmail"];
			$pPhone = $row["cPhone"];
			$pMobile = $row["cMobile"];
			$pRolle = $row["cRolle"];
		}
		
		echo '<div class="container">';
			echo '<form class="form-horizontal" role="form" method="post">';
				echo '<input type="text" style="display: none" id="fakeUsername" name="fakeUsername" value="" />';
				echo '<input type="password" style="display: none" id="fakePassword" name="fakePassword" value="" />';
				echo '<div class="form-group">';
					echo '<h2 class="col-md-4 control-label">'; echo "$pVorname $pNachname's Profil"; // PROFIL NAME
					echo '</h2>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">ID</label>';
					echo '<div class="col-md-4">';
						echo '<div class="control-txt">'; echo $pID; echo '</div>'; // BenutzerID
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Vorname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="vorname" value="';
							echo $pVorname;  // VORNAME
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Nachname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="nachname" value="';
							echo $pNachname; // NACHNAME
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Username *</label>';
						echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="username" value="';
							echo $pUsername; // UESERNAME
						echo'"type="text" required>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">E-Mail Adresse</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="email" value="';
							echo $pEmail;  // MAIL
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Telephonnummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="phone" value="';
							echo $pPhone; // PHONE
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Handynummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="mobile" value="';
							echo $pMobile; // MOBILE
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Rolle *</label>'; // ROLLE
					echo '<div class="col-md-4">'; 
						echo '<select class="form-control" name="rolle" id="rolle" required>';
							echo '<option value="0"'; if ($pRolle==0) echo 'selected="selected"'; echo '></options>';		
							echo '<option value="1"'; if ($pRolle==1) echo 'selected="selected"'; echo '>Administrator</options>';
							echo '<option value="2"'; if ($pRolle==2) echo 'selected="selected"'; echo '>Benutzer</options>';
						echo '</select>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Neues Passwort</label>'; //NEUES PW
					echo '<div class="col-md-4">';
						echo '<input type="password" name="passwort" class="form-control" id="focusedInput" type="text">';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label"></label>';
					echo '<div class="col-md-2">';
						echo '<button class="btn btn-primary btn-block" name="save-user" type="submit" >Speichern</button>';
					echo '</div>';
					echo '<div class="col-md-2">';
						echo '<a class="btn btn-default btn-block" href="usermanagement.php" role="button">Zurück</a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-md-4 control-label"></label>';
					echo '<div class="col-md-2">';
						echo '<button class="btn btn-danger btn-block" name="delete-user" type="submit" >Delete</button>';
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
		echo '<div class="container"><div class="alert alert-danger"> <strong>Error: </strong>Dieser User existiert nicht.</div></div>';
	}
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
}
?>