<?php
/** Variables */
$title = "TSW │ Log-In";
$header = "login";
$navbar = 3;

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
	session_start();
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	//Startpage
	$param= "";
	if(!empty($_POST["id"]))
	{
		$param="?id=".$_POST["id"];
	}
	$startPage= $_POST["page"].$param;
	
	// Passwort to Sha
	$password = toSha($password);
	
	// Username to lowercase
	$username = strtolower($username);
	 
	/* create a prepared statement */
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=? and cPasswort=?")) 
	{
		mysqli_stmt_bind_param($stmt, "ss", $username, $password);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		if ($result->num_rows > 0)
		{	
			mysqli_fetch_array($result, MYSQLI_NUM);
			foreach ($result as $row)
			{
				// Save Session Variables
				$_SESSION["user_id"] = $row["cBenutzerID"];
				$_SESSION["user_username"] = $row["cUsername"];
				$_SESSION["user_nachname"] = $row["cNachname"];
				$_SESSION["user_vorname"] = $row["cVorname"];
				$_SESSION["user_role"] = $row["cRolle"];
				
				// Redirect to chosen Page
				header("Location: ".$startPage);
			}
		}
		else
		{
			$loginError = '<div class="alert alert-danger">Falscher Benutzername oder Passwort.</div>';
		}
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