<?php
/** Variables */
$title = "TSW │ Neuer Nutzer erfassen";
$header = "normal";
$navbar = 1;

$validationError = "";
$error = 0;

$newUserVorname = "";
$newUserNachname = "";
$newUserName = "";
$newUserEmail= "";
$newUserPhone = "";
$newUserMobile = "";
$newUserPasswort = "";
$newUserRolle = "";

/** Includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/checkauth.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');

if(isset($_POST['neuer-nutzer']))
{
	$newUserVorname = $_POST["vorname"];
	$newUserNachname = $_POST["nachname"];
	$newUserName = $_POST["username"];
	$newUserEmail= $_POST["email"];
	$newUserPhone = $_POST["phone"];
	$newUserMobile = $_POST["mobile"];
	$newUserPasswort = $_POST["passwort"];
	$newUserRolle = $_POST["rolle"];
	
	$newUserVorname = strip_tags($newUserVorname);
	$newUserNachname = strip_tags($newUserNachname);
	$newUserName = strip_tags($newUserName);
	$newUserEmail= strip_tags($newUserEmail);
	$newUserPhone = strip_tags($newUserPhone);
	$newUserMobile = strip_tags($newUserMobile);
	
	if ($newUserRolle === "Administrator")
	{
		$newUserRolle = "1";
	}
	elseif ($newUserRolle === "Benutzer")
	{
		$newUserRolle = "2";
	}
	
	if (mb_strlen($newUserVorname, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Vorname ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($newUserNachname, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Nachname ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($newUserName, 'utf8')  > 32)
	{
		$validationError .= "Fehler: Der Username ist zu lang. Er darf maximal 32 Zeichen enthalten.";
		$error = 1;
	}
	if (mb_strlen($newUserEmail, 'utf8')  > 255)
	{
		$validationError .= "Fehler: Die E-Mail-Adresse ist zu lang. Er darf maximal 255 Zeichen enthalten.";
		$error = 1;
	}
	if ($newUserPhone != 0)
	{
		if(!preg_match("/^[0-9]{13}$/", $newUserPhone))
		{
			$validationError .= "Fehler: Geben Sie eine gültige Telefon-Nummer ein.";
			$error = 1;
		}
	}
	if ($newUserMobile != 0)
	{
		if(!preg_match("/^[0-9]{13}$/", $newUserMobile))
		{
			$validationError .= "Fehler: Geben Sie eine gültige Mobiltelefon-Nummer ein.";
			$error = 1;
		}
	}
	if (!filter_var($newUserEmail, FILTER_VALIDATE_EMAIL)) {
		$validationError .= "Fehler: Geben Sie eine gültige E-mail Adresse an ein.";
		$error = 1;
	}
	
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cEmail=?");
	mysqli_stmt_bind_param($stmt, "s", $newUserEmail);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_num_rows($stmt) > 0)
	{
		$validationError .= "Fehler: Die angegebene E-mail wird bereits wird bereits verwendet. Bitte geben Sie eine andere an.";
		$error = 1;
	}
	mysqli_stmt_close($stmt);
	
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=?");
	mysqli_stmt_bind_param($stmt, "s", $newUserName);
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
		$newUserPasswort = toSha($newUserPasswort);
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, 'INSERT INTO tbenutzer SET cVorname=?, cNachname=?,  cUsername=?, cEmail=?, cPhone=?, cMobile=?, cPasswort=?, cRolle=?');
		mysqli_stmt_bind_param($stmt, "sssssssi", $newUserVorname, $newUserNachname, $newUserName, $newUserEmail, $newUserPhone, $newUserMobile, $newUserPasswort, $newUserRolle);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
		
}




?>
<div class="container">
	<form class="form-horizontal" role="form" method="post" autocomplete="off">
	
	<!-- Fake Passwortfelder, damit Firefox nicht immer die falschen abfüllt -->
	<input type="text" style="display: none" id="fakeUsername" name="fakeUsername" value="" />
	<input type="password" style="display: none" id="fakePassword" name="fakePassword" value="" />
	
		<div class="form-group">
			<h2 class="col-md-4 control-label">Neuer Nutzer</h2>     	
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Vorname *</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="vorname" value="<?php echo $newUserVorname; ?>" type="text" required>
			</div>                	
		</div>    
		<div class="form-group">
			<label class="col-md-2 control-label">Nachname *</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="nachname" value="<?php echo $newUserNachname; ?>" type="text" required>
			</div>                	
		</div>   	
		<div class="form-group">
			<label class="col-md-2 control-label">Username *</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="username" value="<?php echo $newUserName; ?>" type="text" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">E-Mail Adresse *</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="email" value="<?php echo $newUserEmail ?>"type="text" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Telephonnummer</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="phone" value="<?php echo $newUserPhone ?>" type="text">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Handynummer</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="focusedInput" name="mobile" value="<?php echo $newUserMobile ?>"type="text">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Passwort *</label>
			<div class="col-md-4">
				<input type="password" class="form-control" id="focusedInput" name="passwort" type="text" autocomplete="off" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Rolle *</label>
			<div class="col-md-4">
				<select class="form-control" name="rolle" id="rolle" required>
					<option></option>
                	<option>Benutzer</option>
                	<option>Administrator</option>
                </select>
			</div>
		</div>
		 
		<div class="form-group">
			<label class="col-md-2 control-label"></label>
			<div class="col-md-2">
				
				<button class="btn btn-primary btn-block" type="submit" name="neuer-nutzer" >Speichern</button>
			</div>
			<div class="col-md-2">
				<a class="btn btn-default btn-block" href="index.php" role="button">Zurück</a>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-2 control-label"></label>
			<div class="col-md-4">
				<?php echo $validationError;?>
			</div>
		</div>
	</form>
</div>