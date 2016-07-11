<?php
/** variables */
$title = "TSW │ Log-In";
$header = "login";
$navbar = 3;
$active = 1;

/** standard page and id */
$page = "index.php";
$id = "";
$loginError = "";

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/navigation.inc.php');

/** defines standard page when available */
if(isset($_REQUEST["page"]))
{
	$page = $_REQUEST["page"];
}
if(isset($_REQUEST["id"]))
{
	$id = $_REQUEST["id"];
}

/** post-back for login */
if(isset($_POST['log-in']))
{
	/** starts session */
	session_start();
	
	/** get pw and name for login */
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	/** defines standard page when available */
	$param= "";
	if(!empty($_POST["id"]))
	{
		$param="?id=".$_POST["id"];
	}
	$startPage= $_POST["page"].$param;
	
	/** passwort to hash */
	$password = toSha($password);
	
	/** username to lowercase */
	$username = strtolower($username);
	 
	/** login */
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=? and cPasswort=? and cAktiv=?")) 
	{
		/** get rows */
		mysqli_stmt_bind_param($stmt, "ssi", $username, $password, $active);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		
			/** redirect to defined startpage */
			if (mysqli_stmt_num_rows($stmt) > 0)
			{
				mysqli_stmt_bind_param($stmt, "ssi", $username, $password, $active);
				mysqli_stmt_execute($stmt);
				
				$result = mysqli_stmt_get_result($stmt);
				mysqli_fetch_array($result, MYSQLI_NUM);
				
				/** write session */
				foreach ($result as $row)
				{
					/** save session variables */
					$_SESSION["user_id"] = $row["cBenutzerID"];
					$_SESSION["user_username"] = $row["cUsername"];
					$_SESSION["user_nachname"] = $row["cNachname"];
					$_SESSION["user_vorname"] = $row["cVorname"];
					$_SESSION["user_role"] = $row["cRolle"];
				}
				
				/** redirect to defined startpage */
				header("Location: ".$startPage);
			}
			else
			{
				/** login-error */
				$loginError = '<div class="alert alert-danger"> Falscher Benutzername oder Passwort.</div>';
			}
			
		/** close connection */
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
	}
}


?>
<!-- log-in html structure -->
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
/** includes */
include ('include/footer.inc.php');
?>