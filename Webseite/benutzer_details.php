<?php
/** Variables */
$title = "TSW │ Benutzerdetail";
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

$detailId = $_GET['id'];
?>