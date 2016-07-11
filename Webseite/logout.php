<?php
/** variables */
$title = "TSW │ Log-Out";
$header = "login";
$navbar = 3;

/** includes */
include ('include/functioncontroller.inc.php');
include ('include/header.inc.php');
include ('include/dbconnection.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');

/** log-out */
logOut();
?>