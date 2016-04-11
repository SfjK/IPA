<?php
/** variables */
$title = "TSW │ Ticketübersicht";
$header = "normal";
$navbar = 1;

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/pdoclass.inc.php');
include ('include/checkauth.inc.php');
include ('include/navigation.inc.php');
include ('include/ticketfilter.inc.php');
include ('include/ticketliste.inc.php');
include ('include/footer.inc.php');
?>