<?php
ob_start();
/** Variables */
$title = "TSW │ Usermanagement";
$header = "normal";
$navbar = 1;

/** Includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/checkauth.inc.php');
include ('include/checkrole.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');
?>

<div class="container">
	<form class="form-horizontal" role="form">
		<div class="form-group form-group">
			<h2 class="col-md-4 control-label">Usermanager</h2>
		</div>
		<div class="form-group form-group">
        	<div class="col-sm-10"></div>	
			<div class="col-sm-2">
				<label for="bneuernutzer">User erfassen</label>			
           		<a class="btn btn-block btn-success" id="bneuernutzer" href="neuernutzer.php"><span class="glyphicon glyphicon-plus"></span> User erfassen</a>		
			</div>		
  		</div>
    </form>
</div>
<?php 
include ('include/userlist.inc.php');
?>