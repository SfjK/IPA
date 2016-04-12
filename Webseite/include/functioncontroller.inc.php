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
function getTicketfile($tid)
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

function getOldTicketData($ticketID)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('
		SELECT cTicketID, cTicketTitle, tkategorie.cKategorieID, cTicketBeschreibung, tkategorie.cKategorieName,
		R1.cUsername AS Owner, R1.cEmail AS Email, R2.cEmail AS Emailsupporter, R2.cUsername AS Supporter, R2.cBenutzerID AS SupportID,
		cSupporterID, cOwnerID,
		cTicketDeadline, cTicketLastChange, cTicketCreateDate,
		tstatus.cStatusName, ttickets.cStatusID AS StatusID
		FROM ttickets
		INNER JOIN tkategorie ON ttickets.cKategorieID = tkategorie.cKategorieID
		INNER JOIN tstatus ON ttickets.cStatusID = tstatus.cStatusID
		INNER JOIN tbenutzer R1 ON ttickets.cOwnerID = R1.cBenutzerID
		INNER JOIN tbenutzer R2 ON ttickets.cSupporterID = R2.cBenutzerID
		WHERE cTicketID=:ticketid');
	$stmt->bindParam(':ticketid', $ticketID, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch();
	return $result;
}


function getNewSupporter($ticketsupporter)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cBenutzerID, cUsername FROM tbenutzer Where cBenutzerID=:benutzerid');
	$stmt->bindParam(':benutzerid', $ticketsupporter, PDO::PARAM_STR);
	$stmt->execute();
	$rowcount = $stmt->rowCount();
	$resultforsupporter = $stmt->fetch();
	return $resultforsupporter;
}

function getNewStatusData($ticketStatus)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cStatusID, cStatusName FROM tstatus Where cStatusID=:statusid');
	$stmt->bindParam(':statusid', $ticketStatus, PDO::PARAM_STR);
	$stmt->execute();
	$rowcount = $stmt->rowCount();
	$resultForStatus = $stmt->fetch();
	return  $resultForStatus;
}

function getSupporterEmail($ticketSupporter)
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('SELECT cBenutzerID, cEmail FROM tBenutzer Where cBenutzerID=:benutzerid');
	$stmt->bindParam(':benutzerid', $ticketSupporter, PDO::PARAM_STR);
	$stmt->execute();
	$resultForSupporter = $stmt->fetch(); //gibt array zurück
	return $resultForSupporter;
}

function updateTicket($ticketTitle, $ticketBeschreibung, $ticketThema, $ticketSupporter, $ticketErstellungsdatum, $ticketEndtermin, $ticketStatus, $ticketID )
{
	$con=dbConn::getConnection();
	$stmt = $con->prepare('
				UPDATE ttickets SET cTicketTitle=:tickettitle, cTicketBeschreibung=:ticketbeschreibung, cKategorieID=:ticketthema,
				cSupporterID=:ticketsupporter,
				cTicketCreateDate=:ticketerstellungsdatum,
				cTicketDeadline=:ticketdeadline,
				cStatusID=:ticketstatus
				WHERE cTicketID=:ticketid');
	$stmt->bindParam(':tickettitle', $ticketTitle, PDO::PARAM_STR);
	$stmt->bindParam(':ticketbeschreibung', $ticketBeschreibung, PDO::PARAM_STR);
	$stmt->bindParam(':ticketthema', $ticketThema, PDO::PARAM_STR);
	$stmt->bindParam(':ticketsupporter', $ticketSupporter, PDO::PARAM_STR);
	$stmt->bindParam(':ticketerstellungsdatum', $ticketErstellungsdatum, PDO::PARAM_STR);
	$stmt->bindParam(':ticketdeadline', $ticketEndtermin, PDO::PARAM_STR);
	$stmt->bindParam(':ticketstatus', $ticketStatus, PDO::PARAM_STR);
	$stmt->bindParam(':ticketid', $ticketID, PDO::PARAM_STR);
	$stmt->execute();
}

function validateUser($conn, $userVorname, $userNachname, $userName, $userPhone, $userMobile, $userEmail, $userid , $validationError)
{
	if (mb_strlen($userVorname, 'utf8')  > 32)
	{
		$validationError .= "· Der Vorname ist zu lang. Er darf maximal 32 Zeichen enthalten.<br/>";
		$error = 1;
	}
	if (mb_strlen($userVorname, 'utf8')  < 3)
	{
		$validationError .= "· Der Vorname ist zu kurz. Er muss mindestens 3 Zeichen enthalten.<br/>";
		$error = 1;
	}
	if (mb_strlen($userNachname, 'utf8')  > 32)
	{
		$validationError .= "· Der Nachname ist zu lang. Er darf maximal 32 Zeichen enthalten.<br/>";
		$error = 1;
	}
	if (mb_strlen($userNachname, 'utf8')  < 3)
	{
		$validationError .= "· Der Nachname ist zu kurz. Er muss mindestens 3 Zeichen enthalten.</br>";
		$error = 1;
	}
	if (mb_strlen($userEmail, 'utf8')  > 255)
	{
		$validationError .= "· Die E-Mail-Adresse ist zu lang. Er darf maximal 255 Zeichen enthalten.</br>";
		$error = 1;
	}
	if (!empty($userPhone))
	{
		if(!preg_match("/^[0-9]{13}$/", $userPhone))
		{
			$validationError .= "· Geben Sie eine gültige Telefon-Nummer ein. Bsp. 0041000000000</br>";
			$error = 1;
		}
	}
	if (!empty($userMobile))
	{
		if(!preg_match("/^[0-9]{13}$/", $userMobile))
		{
			$validationError .= "· Geben Sie eine gültige Mobiltelefon-Nummer ein. Bsp. 0041000000000</br>";
			$error = 1;
		}
	}
	if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
	{
		$validationError .= "· Geben Sie eine gültige E-mail Adresse an ein.</br>";
		$error = 1;
	}

	if (!empty($userid))
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cEmail=? && cBenutzerID!=?");
		mysqli_stmt_bind_param($stmt, "si", $userEmail, $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) > 0)
		{
			$validationError .= "· Die angegebene E-mail wird bereits wird bereits verwendet. Bitte geben Sie eine andere an.</br>";
			$error = 1;
		}
		
		if (!empty($userName))
		{
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=? && cBenutzerID!=?");
			mysqli_stmt_bind_param($stmt, "ss", $userName, $userid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			if (mysqli_stmt_num_rows($stmt) > 0)
			{
				$validationError .= "· Es existiert bereits ein User mit diesem Username. Nutzen Sie bitte einen anderen.<br/>";
				$error = 1;
			}
		}
		mysqli_stmt_close($stmt);
	}
	
	if (empty($userid))
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cEmail=?");
		mysqli_stmt_bind_param($stmt, "s", $userEmail);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) > 0)
		{
			$validationError .= "· Die angegebene E-mail wird bereits wird bereits verwendet. Bitte geben Sie eine andere an.";
			$error = 1;
		}
		mysqli_stmt_close($stmt);
		
		if (!empty($userName))
		{
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "SELECT * FROM tbenutzer WHERE cUsername=?");
			mysqli_stmt_bind_param($stmt, "s", $userName);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			if (mysqli_stmt_num_rows($stmt) > 0)
			{
				$validationError .= "· Es existiert bereits ein User mit diesem Username. Nutzen Sie bitte einen anderen.";
				$error = 1;
			}
		}
		mysqli_stmt_close($stmt);
	}
	
	return $validationError;
}

function createNewTicket($con, $datei)
{
	if(!isset($datei['fileToUpload']) || $datei['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE)
	{
		$ticketerror = "";
		createTicket($con, $datei);
	}
	else
	{
		$ticketerror = checkFile($con, $datei);
		return $ticketerror;
		
	}
}



function checkFile($con, $datei)
{
	$ticketerror ="";
	$fileerror="";
	$target_dir = "uploads/";
	$filename = $datei["fileToUpload"]["name"];
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$file_ext = strtolower($file_ext);
	$hashfilename = md5($filename);
	$salt = mt_rand();
	$target_file = $target_dir.$salt.$hashfilename.$file_ext;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$imageFileType = strtolower($imageFileType);
	$uploadOk = 1;

	// Check if file already exists
	if (file_exists($target_file))
	{
		$fileerror .= '· Die Datei existiert bereits. Bitte wähle einen anderen Dateinamen. </br>';
		$uploadOk = 0;
	}

	// Check size
	if ($datei["fileToUpload"]["size"] > 5000000)
	{
		$fileerror .= '· Die Datei darf maximal 5MB gross sein.</br>';
		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "zip" && $imageFileType != "pdf")
	{
		$fileerror .= '· Es sind nur die Formate JPG, JPEG, PNG, GIF, PDF und ZIP erlaubt.</br>';
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0)
	{
		$ticketerror = '<div class="alert alert-danger">Upload Fehler: </br>'.$fileerror.'</div>';
		return $ticketerror;
	}
	else
	{
		createTicket($con);
		saveFile($target_file, $con, $datei, $filename);
	}
};

function createTicket($con)
{
	$tickettitle = $_POST["ticket-title"];
	$ticketkategorieid = $_POST["ticket-thema"];
	$ticketdesc = $_POST["ticket-beschreibung"];
	$ticketdeadline = $_POST["ticket-endtermin"];
	$owner = $_SESSION["user_id"];
	$ticketusername = $_SESSION["user_username"];
	$ticketnachname = $_SESSION["user_nachname"];
	$ticketvorname = $_SESSION["user_vorname"];
	$stmt = $con->prepare('INSERT INTO ttickets SET cTicketTitle=:tickettitle, cKategorieID=:kategorieid, cTicketbeschreibung=:ticketdesc, cTicketDeadline=:ticketdeadline, cOwnerID=:ticketowner');
	$stmt->bindParam(':tickettitle', $tickettitle, PDO::PARAM_STR);
	$stmt->bindParam(':kategorieid', $ticketkategorieid, PDO::PARAM_STR);
	$stmt->bindParam(':ticketdesc', $ticketdesc, PDO::PARAM_STR);
	$stmt->bindParam(':ticketdeadline', $ticketdeadline, PDO::PARAM_STR);
	$stmt->bindParam(':ticketowner', $owner, PDO::PARAM_STR);
	$stmt->execute();
	$last_ticketid = $con->lastInsertId();
	sendMail($last_ticketid, $tickettitle, $ticketusername, "Neues Ticket", $ticketvorname, $ticketnachname, "", "", "ske@sba.ch");
};

function saveFile($target_file, $con, $datei, $filename)
{
	if (move_uploaded_file($datei["fileToUpload"]["tmp_name"], $target_file))
	{
		fileToDb($con, $target_file, $filename);
	}
	else
	{
		$ticketerror = '<div class="alert alert-danger">Es gab einen Fehler beim Upload der Datei';
	}
};

function fileNameToDb($con, $target_file, $filename)
{
	$last_ticketid = $con->lastInsertId();
	// 		$filename =  $datei["fileToUpload"]["name"];
	$stmt = $con->prepare('INSERT INTO tfiles SET cFilepath=:filepath, cFileName=:filename');
	$stmt->bindParam(':filepath', $target_file, PDO::PARAM_STR);
	$stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
	$stmt->execute();
	return $last_ticketid;
};

function fileConnectionToDb($con, $last_ticketid)
{
	$last_fileid = $con->lastInsertId();
	$stmt = $con->prepare('INSERT INTO tticketfiles SET cTicketID=:ticketid, cFileID=:fileid');
	$stmt->bindParam(':ticketid', $last_ticketid, PDO::PARAM_STR);
	$stmt->bindParam(':fileid', $last_fileid, PDO::PARAM_STR);
	$stmt->execute();
	$last_fileid = $con->lastInsertId();
};

function fileToDb($con, $target_file, $filename)
{
	$lastticketid = fileNameToDb($con, $target_file, $filename);
	fileConnectionToDb($con, $lastticketid);
};

?>
