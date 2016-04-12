<?php
/**
 * Creates Ticket E-Mails and sends them
 *
 * @param {int} $ticketID
 * @param {string} $tTitle - Ticket Title
 * @param {string} $tOwner - Ticket Owner
 * @param {string} $mType  - E-Mail Type
 * @param {string} $tVorname - Ticket Vorname
 * @param {string} $tNachname - Ticket Nachname
 * @param {string} $tSupporter - Ticket Supporter
 * @param {string} $tStatus - Ticket Status
 * @param {string} $tEmpfaenger - Ticket Empfänger
 * @return {boolean} true / false - Mail is sent / is not sent
 */
function sendMail( $ticketID, $tTitle, $tOwner, $mType, $tVorname ,$tNachname, $tSupporter , $tStatus, $tEmpfaenger)
{
	/**
	 * define values which are used for every email
	 */
	
	/** absender */
	$absender = 'Automatische Ticketbenachrichtigung <samuel.keller@sba.ch>';
	
	/** email header */
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf8' . "\r\n";
	$header .= 'To: '.$tEmpfaenger. "\r\n";
	$header .= 'From: '.$absender. "\r\n";
	
	/** email css */
	$mailHead = '
	<head>
		<title>Automatische Ticket-Benachrichtigung</title>
		<style type="text/css">
		body, p {
	    font-family: arial;
		}
		table td, th {
	  	text-align: left;
		}
		</style>
	</head>';
	
	/** email title */
	$mailtTitel = '<p style="font-family: arial;">Automatische Ticket-Benachrichtigung</p>';
	
	/** email table title */
	$mailTableTitle = '<tr><th colspan="2">Weitere Ticketinformationen:</th></tr>';
	
	/** email default table values */
	$mailTableDefault = '
	<tr>
      	<td>Nummer:</td><td>'.$ticketID.'</td>
    </tr>
    <tr>
      	<td>Titel:</td><td>'.$tTitle.'</td>
    </tr>';
	
	/** email footer / byebye from admins */
	$mailFooter = '<p>Freundliche Grüsse</br>Das Administratoren-Team</p>';
	
	/** link to ticket */
	$mailLink = '<p><a href="http://sbahp080/login.php?page=/ticket_details.php&id='.$ticketID.'">Zum Ticket</a></p>';
	
	/**
	 * change email text for different email types
	 */
	if ($mType === "Neues Ticket")
	{
		/** email betreff */
		$betreff = '
		Ein neues Ticket wurde erfasst';	
		
		/** email text */
		$mailText= '
		<p>Soeben wurde ein neues Ticket von Herr '.$tVorname.' '.$tNachname.' mit dem Titel "'.$tTitle.'" erfasst.
		</br>
		Bitte teilen Sie dem Ticket einen Supporter zu.</p>';
		
		/** email special table */
		$mailTable = '
	    <tr>
	      	<td>Erfasser:</td><td>'.$tOwner.'</td>
	    </tr>
	     <tr>
	      	<td>Name:</td><td>'.$tVorname.' '.$tNachname.'</td>
	    </tr>';
		
		/** ticket action */
		$mailTableAction= '<tr><td>Aktion:</td><td> Ticket erfasst</td></tr>';
	}
	elseif ($mType === "Administrator zugewiesen")
	{
		/** email betreff */
		$betreff = 'Ticket '.$ticketID.' - Zuweisung erfolgt';
		
		/** email text */
		$mailText= '
		<p>Sehr geehrter Benutzer</p>
		<p>Ihr Ticket "'.$tTitle.'" mit der Nummer '.$ticketID.' wurde dem Supporter '.$tSupporter.' zugewiesen.</p>';
		
		/** email special table */
		$mailTable = '
	   	<tr>
	      	<td>Supporter:</td><td>'.$tSupporter.'</td>
	    </tr>';
		
		/** ticket action */
		$mailTableAction= '
		<tr>
			<td>Aktion:</td><td> Ticket einem '.$mType.'</td>
		</tr>';
	}
	elseif ($mType === "Status")
	{
		/** email betreff */
		$betreff = 'Ticket '.$ticketID.' - Status geändert';
		
		/** email text */
		$mailText= '
		<p>Sehr geehrter Benutzer</p>
		<p>Der Status ihres Tickets "'.$tTitle.'" wurde auf "'.$tStatus.'" gesetzt.</br></p>';
		
		/** email special table */
		$mailTable = '
	   	<tr>
	      	<td>Supporter:</td><td>'.$tSupporter.'</td>
	    </tr>';   
		
		/** ticket action */
		$mailTableAction= '<tr><td>Aktion:</td><td> Ticket '.$tStatus.'</td></tr>';
	}
	elseif ($mType === "Administrator E-Mail")
	{
		/** email betreff */
		$betreff = 'Ticket '.$ticketID.' - Zuweisung erfolgt';
		
		/** email text */
		$mailText= '
		<p>Sehr geehrter Administrator</p>
		<p>Das Ticket "'.$tTitle.'" mit der Nummer '.$ticketID.' wurde Ihnen zugewiesen.</p>';
		
		/** email special table */
		$mailTable = '
	   	<tr>
	      	<td>Supporter:</td><td>'.$tSupporter.'</td>
	    </tr>';
		
		/** ticket action */
		$mailTableAction= '
		<tr>
			<td>Aktion:</td><td> Ticket zugewiesen</td>
		</tr>';
	}
	
	/**
	 * build the whole email from variables
	 */
	$nachricht = '
	<html>
	'.$mailHead.'
	<body>
		'.$mailtTitel.'
		'.$mailText.'
		'.$mailLink.'
		<table>
		    '.$mailTableTitle.'
		    '.$mailTableDefault.'
		    '.$mailTable.'
		   	'.$mailTableAction.'
		</table>
		'.$mailFooter.'
		</body>
	</html>';
		
	/**
	 * sends the email and returns boolean
	 */
	if(mail($tEmpfaenger, $betreff, $nachricht, $header))
	{ 
		return "true";
	}
	else 
	{ 
		return "false";
	}
}
?>