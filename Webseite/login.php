<?php
/** Variables */
$title = "TSW │ Log-In";
$header = "login";
$navbar = 3;
$active = 1;

/** Standard Page and ID */
$page = "index.php";
$id = "";
$loginError = "";

/** Includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/navigation.inc.php');

/** Defines Standard Page when available */
if(isset($_REQUEST["page"]))
{
	$page = $_REQUEST["page"];
}
if(isset($_REQUEST["id"]))
{
	$id = $_REQUEST["id"];
}

/** Post-Back for Login */
if(isset($_POST['log-in']))
{
	/** Starts Session */
	session_start();
	
	/** Get PW and Nema for Login */
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	/** Defines Standard Page when available */
	$param= "";
	if(!empty($_POST["id"]))
	{
		$param="?id=".$_POST["id"];
	}
	$startPage= $_POST["page"].$param;
	
	/** Passwort to Hash */
	$password = toSha($password);
	
	/** Username to Lowercase */
	$username = strtolower($username);
	 
	/** Login */
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=? and cPasswort=? and cAktiv=?")) 
	{
		/** Get Rows */
		mysqli_stmt_bind_param($stmt, "ssi", $username, $password, $active);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		
			/** Redirect to defined Startpage */
			if (mysqli_stmt_num_rows($stmt) > 0)
			{
				mysqli_stmt_bind_param($stmt, "ssi", $username, $password, $active);
				mysqli_stmt_execute($stmt);
				
				$result = mysqli_stmt_get_result($stmt);
				mysqli_fetch_array($result, MYSQLI_NUM);
				
				/** Write Session */
				foreach ($result as $row)
				{
					/** Save Session Variables */
					$_SESSION["user_id"] = $row["cBenutzerID"];
					$_SESSION["user_username"] = $row["cUsername"];
					$_SESSION["user_nachname"] = $row["cNachname"];
					$_SESSION["user_vorname"] = $row["cVorname"];
					$_SESSION["user_role"] = $row["cRolle"];
				}
				
				/** Redirect to defined Startpage */
				header("Location: ".$startPage);
			}
			else
			{
				/** Login-Error */
				$loginError = '<div class="alert alert-danger"> Falscher Benutzername oder Passwort.</div>';
			}
			
		/** Close Connection */
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
	}
}


?>
<!-- Log-In Html Structure -->
<div class="container">
	<form class="login-form" action="login.php" method="post" >
		<h3 class="login-titel">Log-In</h3>
		<input type="text" class="form-control" id="benutzername" name="username" placeholder="Benutzername" required autofocus >
		<input type="password" class="form-control" id="passwort" name="password" placeholder="Passwort" required>
		
		<!-- Hidden Values -->
		<input type="hidden" name="page" value="<?php echo $page; ?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		
		<button class="btn btn-primary btn-block" type="submit" id="logbutton" name="log-in">Anmelden <span class="glyphicon glyphicon-log-in"></span></button>
		<?php echo $loginError; ?>
	</form>    
</div> 
    
<?php 
/** Includes */
include ('include/footer.inc.php');
?>