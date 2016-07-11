<?php
/** variables */
$title = "TSW │ Benutzerdetail";
$header = "normal";
$navbar = 1;
$validationError = "";
$error = 0;
$active = 1;
$notactive = 0;
$detailId = $_GET['id'];

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/checkauth.inc.php');
include ('include/checkrole.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');

/** 
 * deaktivate user 
 */
if(isset($_POST['deactivate-user']))
{
	/** deactivate active user by id */
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "UPDATE tbenutzer SET cAktiv=? WHERE cBenutzerID=?");
	mysqli_stmt_bind_param($stmt, "ii", $notactive, $detailId);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
	
	/** redirect to usermanager */
	header('Location: usermanagement.php');
}

/** 
 * save user 
 */
if(isset($_POST['save-user']))
{
	/** get postback */
	$tempVorname = $_POST["vorname"];
	$tempNachname = $_POST["nachname"];
	$userName = $_POST["username"];
	$userEmail= $_POST["email"];
	$userPhone = $_POST["phone"];
	$userMobile = $_POST["mobile"];
	$userPasswort = $_POST["passwort"];
	$userRolle = $_POST["rolle"];
	
	/** strip all variables */
	$tempVorname = strip_tags($tempVorname);
	$tempNachname = strip_tags($tempNachname);
	$userName = strip_tags($userName);
	$userEmail= strip_tags($userEmail);
	$userPhone = strip_tags($userPhone);
	$userMobile = strip_tags($userMobile);
	
	/** validation */
	$validationError = validateUser($conn, $tempVorname, $tempNachname, $userName, $userPhone, $userMobile, $userEmail, $detailId, $validationError);
	
	/** display error if existent */
	if (!empty($validationError))
	{
		$validationError = '<div class="alert alert-danger">'.$validationError.'</div>';
	}
	
	/** 
	 * save user when no error exists
	 */
	if (empty($validationError))
	{
		/** 
		 * when password is empty, save without it 
		 * else save with password
		 */
		if (empty($userPasswort))
		{
			/** save without password */
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?,cUsername=?, cEmail=?, cPhone=?, cMobile=? ,cRolle=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "ssssssii", $tempVorname, $tempNachname,$userName,$userEmail, $userPhone, $userMobile,$userRolle, $detailId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		else
		{	
			/** save with password */
			$userPasswort = toSha($userPasswort);
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, 'UPDATE tbenutzer SET cVorname=?, cNachname=?,cUsername=?, cEmail=?, cPhone=?, cMobile=? ,cPasswort=?,cRolle=? WHERE cBenutzerID=?');
			mysqli_stmt_bind_param($stmt, "sssssssii", $tempVorname, $tempNachname,$userName, $userEmail, $userPhone, $userMobile, $userPasswort ,$userRolle, $detailId);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		/**
		 * if logged-in user changes his own values via usermanager
		 * update navigation and session
		 */
		if ($_SESSION["user_id"] == $detailId)
		{
			$userVorname = $tempVorname;
			$userNachname = $tempNachname;
			$_SESSION["user_username"] = $userName;
			$_SESSION["user_nachname"] = $userNachname;
			$_SESSION["user_vorname"] = $userVorname;
			$_SESSION["user_role"] = $userRolle;
		}
	}
}

/** open connection */
$stmt = mysqli_stmt_init($conn);

/** 
 * get user informations by id and status
 * if user is deactivated or does not exist
 * display error message
 */
if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer Where cBenutzerID=? && cAktiv=?"))
{
	/** get userdata */
	mysqli_stmt_bind_param($stmt, "ii", $detailId,$active);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	/** 
	 * if user exists 
	 * display their information
	 */
	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		/** get userdata */
		mysqli_stmt_bind_param($stmt,"ii", $detailId,$active);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		/** fetch data */
		mysqli_fetch_array($result, MYSQLI_NUM);

		/** bind data to variables for display */
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
		
		/** html structure */
		echo '<div class="container">';
			echo '<form class="form-horizontal" role="form" method="post">';
				echo '<input type="text" style="display: none" id="fakeUsername" name="fakeUsername" value="" />';
				echo '<input type="password" style="display: none" id="fakePassword" name="fakePassword" value="" />';
				
				/** profil name */
				echo '<div class="form-group">';
					echo '<h2 class="col-md-4 control-label">'; echo "$pVorname $pNachname's Profil";
					echo '</h2>';
				echo '</div>';
				
				/** benutzer id */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">ID</label>';
					echo '<div class="col-md-4">';
						echo '<div class="control-txt">'; echo $pID; echo '</div>';
					echo '</div>';
				echo '</div>';
				
				/** first name */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Vorname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="vorname" value="';
							echo $pVorname;
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				
				/** last name */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Nachname</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="nachname" value="';
							echo $pNachname;
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				
				/** username name */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Username *</label>';
						echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="username" value="';
							echo $pUsername;
						echo'"type="text" required>';
					echo '</div>';
				echo '</div>';
				
				/** mail */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">E-Mail Adresse *</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="email" value="';
							echo $pEmail;
						echo'"type="text">';
					echo '</div>';
				echo '</div>';
				
				/** phone */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Telephonnummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="phone" value="';
							echo $pPhone;
						echo'"type="text" placeholder="0041000000000">';
					echo '</div>';
				echo '</div>';
				
				/** mobile */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Handynummer</label>';
					echo '<div class="col-md-4">';
						echo '<input class="form-control" id="focusedInput" name="mobile" value="';
							echo $pMobile;
						echo'"type="text" placeholder="0041000000000">';
					echo '</div>';
				echo '</div>';
				
				/** role */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Rolle *</label>';
					echo '<div class="col-md-4">'; 
						echo '<select class="form-control" name="rolle" id="rolle" required>';
							echo '<option value="0"'; if ($pRolle==0) echo 'selected="selected"'; echo '></options>';		
							echo '<option value="1"'; if ($pRolle==1) echo 'selected="selected"'; echo '>Administrator</options>';
							echo '<option value="2"'; if ($pRolle==2) echo 'selected="selected"'; echo '>Benutzer</options>';
						echo '</select>';
					echo '</div>';
				echo '</div>';
				
				/** new password */
				echo '<div class="form-group">';
					echo '<label class="col-md-2 control-label">Neues Passwort</label>';
					echo '<div class="col-md-4">';
						echo '<input type="password" name="passwort" class="form-control" id="focusedInput" type="text">';
					echo '</div>';
				echo '</div>';
				
				/** buttons */
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
					echo '<label class="col-md-2 control-label"></label>';
					echo '<div class="col-md-2">';
						echo '<button class="btn btn-danger btn-block" name="deactivate-user" type="submit" >User deaktivieren</button>';
					echo '</div>';
				echo '</div>';
				
				/** validation error */
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
		/** alert */
		echo '<div class="container"><div class="alert alert-danger"><strong>Error: </strong>Dieser User existiert nicht oder ist deaktiviert.</div></div>';
	}
	
	/** close db connection */
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
}
?>