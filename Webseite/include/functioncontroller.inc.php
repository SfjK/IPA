<?php
/**
 * Password to sha512
 *
 * @param {String} $hp - Password
 * @return {String} $hashpassword - Password as sha512
 */
function toSha($hp)
{
	$hashpasswort = hash('sha512', $hp);
	return $hashpasswort;
}

/**
 * Logs user out
 *
 * @param {void}
 * @return {void}
 */
function logOut()
{
	/** Destroy session */
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	
	/** Delete cookie*/
	setcookie(session_name(),'',0,'/');
	
	/** Logout html */
	echo '<div class="container">';
		echo '<h2>Logout</h2>';
		echo '<p>Sie werden ausgeloggt</p>';
	echo '</div>';
	
	/** Redirect to loginpage */
	header('Refresh: 1; URL = login.php');
}

function resultAsTicketliste(array $result)
{
	echo '<div class="container">';
	echo '<div class="table-responsive">';
	echo '<table class="table table-hover">';
	echo '<thead>';
	echo '<tr>';
	foreach (array_keys($result[0]) as $key)
	{
		echo '<th>'.$key.'</th>';
	}
	echo "<th></th>";
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach ($result as $key => $row)
	{
		if ($row["Deadline"] == "0000-00-00 00:00:00")
		{
			$row["Deadline"] = "";
		}
		echo '<tr>';
		foreach ($row as $value)
		{
			echo '<td>'.$value.'</td>';
		}
		echo "<td><a class='btn btn-default btn-xs' role='button' href='ticket_details.php?id=".$row['ID']."'>Ansehen<a/></td>";
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
	echo '</div>';
}


function getTicketsfForListe($fTicketStatus, $fTicketKategorie, $fTicketOwner, $fTicketSupporter)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('
	SELECT
	cTicketID AS ID,
	cTicketTitle AS Titel,
	tkategorie.cKategorieName AS Kategorie,
	R1.cUsername AS Erfasser,
	R2.cUsername AS Supporter,
	tstatus.cStatusName AS Status,
	cTicketDeadline AS Deadline
	FROM ttickets
	INNER JOIN tkategorie ON ttickets.cKategorieID = tkategorie.cKategorieID
	INNER JOIN tstatus ON ttickets.cStatusID = tstatus.cStatusID
	INNER JOIN tbenutzer R1 ON ttickets.cOwnerID = R1.cBenutzerID
	INNER JOIN tbenutzer R2 ON ttickets.cSupporterID = R2.cBenutzerID
	WHERE ttickets.cKategorieID LIKE :kategorie &&
	ttickets.cStatusID IN ( '.implode(",",$fTicketStatus).') &&
	ttickets.cOwnerID LIKE :owner &&
	ttickets.cSupporterID LIKE :support
	ORDER BY cTicketID Desc
	');

	$stmt->bindParam(':kategorie', $fTicketKategorie, PDO::PARAM_STR);
	$stmt->bindParam(':owner', $fTicketOwner, PDO::PARAM_STR);
	$stmt->bindParam(':support', $fTicketSupporter, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt;
}

function getEveryCategory()
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT * FROM tkategorie');
	$stmt->execute();
	$fKategorie = $stmt->fetchAll(PDO::FETCH_ASSOC); //gibt array zurück
	return $fKategorie;
}

function getEveryStatus()
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cStatusID, cStatusName FROM tstatus');
	$stmt->execute();
	$fStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $fStatus;
}

function getEveryAdmin()
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cBenutzerID, cUsername FROM tBenutzer WHERE cRolle="1"');
	$stmt->execute();
	$fSupporter = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $fSupporter;
}
function getEveryUserWithoutUser0(){
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cBenutzerID, cUsername FROM tBenutzer WHERE cUsername NOT LIKE "Nicht Zugewiesen"');
	$stmt->execute();
	$fCreator= $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $fCreator;
}
function getTickefile()
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('
           	SELECT ttickets.cTicketID, tfiles.cFileID, tfiles.cFilePath, tfiles.cFileName
           	FROM ttickets
           	INNER JOIN tticketfiles ON ttickets.cTicketID = tticketfiles.cTicketID
           	INNER JOIN tfiles ON tticketfiles.cFileID = tfiles.cFileID
           	WHERE ttickets.cTicketID =:ticketid');
	$stmt->bindParam(':ticketid', $tid, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt;
}

function getTicketById($ticketID)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('
	SELECT cTicketID, cTicketTitle, tkategorie.cKategorieID, cTicketBeschreibung, tkategorie.cKategorieName,
	R1.cUsername AS Owner, R2.cUsername AS Supporter, R2.cBenutzerID AS SupportID,
	cSupporterID, cOwnerID,
	cTicketDeadline, cTicketLastChange, cTicketCreateDate,
	tstatus.cStatusName, ttickets.cStatusID
	FROM ttickets
	INNER JOIN tkategorie ON ttickets.cKategorieID = tkategorie.cKategorieID
	INNER JOIN tstatus ON ttickets.cStatusID = tstatus.cStatusID
	INNER JOIN tbenutzer R1 ON ttickets.cOwnerID = R1.cBenutzerID
	INNER JOIN tbenutzer R2 ON ttickets.cSupporterID = R2.cBenutzerID
	WHERE cTicketID=:ticketid');
	$stmt->bindParam(':ticketid', $ticketID, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt;
}
?>
