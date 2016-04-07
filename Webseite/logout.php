<?php
/** Variables */
$title = "TSW │ Log-Out";
$header = "login";
$navbar = 3;

/** Includes */
include ('include/functioncontroller.inc.php');
include ('include/header.inc.php');
include ('include/dbconnection.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');

/** Log-Out */
logOut();
?>