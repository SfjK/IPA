<?php
/** variables */
$title = "TSW │ Ticket Detailansicht";
$header = "normal";
$navbar = 1;

/** get ticket id */
$ticketID = $_GET['id'];

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/pdoclass.inc.php');
include ('include/checkauth.inc.php');
include ('include/navigation.inc.php');
include ('include/sendmail.inc.php');
include ('include/footer.inc.php');

/** post-back for saving ticket */
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	/** get post */
	$ticketTitle = $_POST["ticket-title"];
	$ticketThema = $_POST["ticket-thema"];
	$ticketBeschreibung = $_POST["ticket-beschreibung"];
	$ticketSupporter = $_POST["ticket-supporter"];
	$ticketErstellungsdatum = $_POST["ticket-erstellungsdatum"];
	$ticketEndtermin = $_POST["ticket-endtermin"];
	$ticketStatus = $_POST["ticket-status"];
	
	/** strip variables */
	$ticketTitle = strip_tags($ticketTitle);
	$ticketBeschreibung = strip_tags($ticketBeschreibung);
	$ticketErstellungsdatum = strip_tags($ticketErstellungsdatum);
	$ticketEndtermin = strip_tags($ticketEndtermin);
	
	/** get the old ticket data */
	$result = getOldTicketData($ticketID);
	
	/** variables for old ticketdata */
	$oldSupporterID = $result["SupportID"];
	$oldOwner = $result["Owner"];
	$oldSupporter = $result["Supporter"];
	$oldStatusID = $result["StatusID"];
	$oldOwnerEmail = $result["Email"];
	$oldSupportEmail = $result["Emailsupporter"];
	
	/** get the new ticketsupporter data */
	$resultForSupporter = getNewSupporter($ticketSupporter); 
	$newSupporter = $resultForSupporter["cUsername"];
	
	/** get the new ticketstatus data */
	$resultForStatus = getNewStatusData($ticketStatus);
	$newStatus = $resultForStatus["cStatusName"];
	
	/** get the supporter email */
	$resultForSupporter = getSupporterEmail($ticketSupporter);
	$supportEmail = $resultForSupporter["cEmail"];
	
	/** 
	 * check if supporter is altert and send mail 
	 */
	if ($oldSupporterID != $ticketSupporter)
	{
		/** send mail */
		sendMail($ticketID, $ticketTitle, $oldOwner, "Administrator zugewiesen", "", "", $newSupporter, $ticketStatus, $oldOwnerEmail);
		sendMail($ticketID, $ticketTitle, $oldOwner, "Administrator E-Mail", "", "", $newSupporter, $ticketStatus, $supportEmail);
	}
	
	/**
	 * check if status is altert and send mail
	 */
	if ($oldStatusID != $ticketStatus)
	{
		/** send mail */
		sendMail($ticketID, $ticketTitle, $oldOwner, "Status", "", "", $newSupporter, $newStatus, $oldOwnerEmail);
	}
	
	/** update Ticket */
	updateTicket($ticketTitle, $ticketBeschreibung, $ticketThema, $ticketSupporter, $ticketErstellungsdatum, $ticketEndtermin, $ticketStatus, $ticketID);
	
	if(isset($_POST['save-ticket-goback']))
	{
		header("Location: index.php");
	}
	
}

/** get ticket */
$stmt = getTicketById($ticketID);

/** get rowcount */
$rowcount = $stmt->rowCount();

/**
 * if a ticket exists with this id exists, fetch it an display it
 * if it does not exist, show them a error
 */
if($rowcount > 0)
{
	/** fetch ticket */
	$result = $stmt->fetch();
	
	/**
	 * if user is administrator, display edit mode
	 * else show only ticket
	 */
	if ($_SESSION["user_role"] == "1")
	{
		echo '<div class="container">';
			echo '<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">';
				echo '<div class="form-group">';
					echo '<h2 class="col-md-4 control-label" >Ticket Detailübersicht</h2>';     	
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">ID</label>';
					echo '<div class="col-sm-8">';
					
						/** display ticket id */
		                echo '<div class="control-txt">'; echo $result["cTicketID"]; echo '</div>';
		                
		            echo '</div>';            	
				echo '</div>'; 
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Titel *</label>';
					echo '<div class="col-sm-8">';
		                echo '<input class="form-control" id="focusedInput" name="ticket-title" type="text" value="';
		                
		                	/** display ticket title */
		                	echo $result["cTicketTitle"];
		                	
		                echo '" required>';
		            echo '</div>';         	
				echo '</div>';    
				echo '<div class="form-group">';
		        	echo '<label class="col-sm-2 control-label">Thema *</label>';
			        echo '<div class="col-sm-8">';
				        echo '<select class="form-control" name="ticket-thema" required>';
				        
				        	/** get every category from db */
 				        	$rkategorie = getEveryCategory();
					   		
 				        	/** list categories from db */
					        foreach ($rkategorie as $key => $row)
					        {
					        	echo '<option value="'.$row['cKategorieID'].'"'; 
					        		if ($result["cKategorieID"]==$row["cKategorieID"]) echo 'selected="selected"'; 
					        	echo '>'.$row['cKategorieName'].'</option>';	
					        }
					        
				        echo '</select>';
			        echo '</div>';                   	
				echo '</div>';   	
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Beschreibung *</label>';
		            echo '<div class="col-sm-8">';
		            	echo '<textarea class="form-control" rows="5" name="ticket-beschreibung" id="comment" required>';
		            	
		            		/** display ticket description */
		            		echo $result["cTicketBeschreibung"]; 
		            		
		            	echo '</textarea>';
		            echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Erfasser</label>';		            	
					echo '<div class="col-sm-8">';
					
						/** display ticket owner */
		                echo '<div class="control-txt">'; echo $result["Owner"]; echo '</div>';
		                
		            echo '</div>';                	
				echo '</div>';
				echo '<div class="form-group">';
		        	echo '<label class="col-sm-2 control-label">Supporter *</label>';
			        echo '<div class="col-sm-8">';
				        echo '<select class="form-control" name="ticket-supporter" required>';		
				        
				        	/** get every admin from db */
				        	$rsupporter = getEveryAdmin();
							
				        	/** list admins from db */
					        foreach ($rsupporter as $key => $row)
					        {
					        	echo '<option value="'.$row['cBenutzerID'].'"'; 
					        		if ($result["cSupporterID"] == $row["cBenutzerID"]) echo 'selected="selected"'; 
					        	echo '>'.$row['cUsername'].'</option>';	
					        }
					        
				        echo '</select>';
			        echo '</div>';      	
				echo '</div>';
			 
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Erstellungsdatum</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="input-group date" id="datetimepicker1" >';
							echo '<input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-erstellungsdatum" value="';
								/** display ticket createdate */
			                	echo $result["cTicketCreateDate"];
							echo '"readonly/>';
							echo '<span class="input-group-addon">';
								echo '<span class="glyphicon glyphicon-calendar"></span>';
							echo '</span>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Endtermin</label>';
					echo '<div class="col-sm-7">';
						echo '<div class="input-group date" id="datetimepicker2" >';
							echo '<input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-endtermin" value="';
								/**
								 * display ticket deadline if it exists
								 * if not, display nothing
								 */
								if ($result["cTicketDeadline"] == "0000-00-00 00:00:00")
								{
									echo "";
								}
								else
								{
									echo $result["cTicketDeadline"];
								}
							echo '"readonly/>';
							echo '<span class="input-group-addon">';
								echo '<span class="glyphicon glyphicon-calendar"></span>';
							echo '</span>';
						echo '</div>';
					echo '</div>';
					echo '<div class="col-sm-1">';
						echo '<button class="btn btn-default btn-block" type="button" onClick="resetEndtermin(); return false;">';
							echo '<span class="glyphicon glyphicon-remove"></span>';
						echo '</button>';
					echo '</div>';
				echo '</div>';
		        echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Last Change</label>';
					echo '<div class="col-sm-8">';
					
						/** display ticket lastchange */
		                echo '<div class="control-txt">'; echo $result["cTicketLastChange"]; echo '</div>';
		                
		            echo '</div>';   	
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label" >Status *</label>';
					echo '<div class="col-sm-8">';
						echo '<select class="form-control" id="sel3" name="ticket-status" required>';
						
							/** get every status from db */
							$rstatus = getEveryStatus();
							
							/** list status from db */
					        foreach ($rstatus as $key => $row)
					        {
					        	echo '<option value="'.$row['cStatusID'].'"'; 
					        		if ($result["cStatusID"] == $row["cStatusID"]) echo 'selected="selected"'; 
					        	echo '>'.$row['cStatusName'].'</option>';	
					        }
					        
						echo '</select>';
					echo '</div>';
				echo '</div>';
		        echo '<div class="form-group">';
		        	echo '<label class="col-sm-2 control-label">Datei</label>';
		           	echo '<div class="col-sm-8" class="form-control">';	
		           	
		           		/** get tickefile */
			           	$stmt = getTicketfile($ticketID);
			           	
			           	/** get rowcount of listing */
			           	$rowcount = $stmt->rowCount();
			           	
			           	/**
			           	 * if a ticketfile exists, fetch it an display it.
			           	 * if it does not exist, show them a error
			           	 */
			           	if($rowcount > 0)
			           	{
			           		$rfile = $stmt->fetch(); 
				           	$filepath = $rfile["cFilePath"];
				           	$filename = $rfile["cFileName"];
			    			echo '<div class="control-txt"><a href="./'. $filepath.'" target="_blank" >'.$filename.'</a></div>';		
			           	}
			           	else 
			           	{	
			           		/** file-error */
			           		echo '<div class="control-txt"> Keine Datei vorhanden</div>';
			           	}
			           	
		            echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<div class="col-sm-2">';
					echo '</div>';
					echo '<div class="col-sm-4">';
						echo '<button class="btn btn-primary btn-block" name="save-ticket-goback" action="index.php" type="submit" >Speichern und Zurück</button>';
					echo '</div>';
					echo '<div class="col-sm-2">';
						echo '<button class="btn btn-default btn-block" name="save-ticket" type="submit">Speichern</button>';
					echo '</div>';
					echo '<div class="col-sm-2">';
						echo '<a class="btn btn-default btn-block" href="index.php" role="button">Zurück</a>';
					echo '</div>';
				echo '</div>';
			echo '</form>';
		echo '</div>';
	}
	else 
	{
		/** 
		 * show to non-admin 
		 * */
		echo '<div class="container">';
			echo '<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">';
				echo '<div class="form-group">';
					echo '<h2 class="col-md-4 control-label" >Ticket Detailübersicht</h2>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">ID</label>';
					echo '<div class="col-sm-8">';
					
						/** display ticket id */
						echo '<div class="control-txt">'; echo $result["cTicketID"]; echo '</div>';
						
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Titel</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">'; 
						
							/** display ticket title */
							echo $result["cTicketTitle"]; 
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label" >Thema</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">';
						
							/** display ticket kategorie */
							echo $result["cKategorieName"];
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Beschreibung</label>';
					echo '<div class="col-sm-8">';
						echo '<textarea class="form-control" name="ticket-beschreibung" readonly>';
						
							/** display ticket description */
							echo $result["cTicketBeschreibung"];
							
						echo '</textarea>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Erfasser</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">';
						
							/** display ticket owner */
							echo $result["Owner"];
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label" >Supporter</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">';
						
							/** display ticket supporter / admin */
							echo $result["Supporter"];
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Erstellungsdatum</label>';
					echo '<div class="col-sm-8">';
					
						/** display ticket createdate */
						echo '<div class="control-txt">'; echo $result["cTicketCreateDate"]; echo '</div>';
						
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Endtermin</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">';
						
							/**
							 * display ticket deadline if it exists
							 * if not, display nothing
							 */
							if ($result["cTicketDeadline"] == "0000-00-00 00:00:00")
							{
								echo "";
							}
							else
							{
								echo $result["cTicketDeadline"];
							}
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Last Change</label>';
					echo '<div class="col-sm-8">';
					
						/** display ticket lastchange date */
						echo '<div class="control-txt">'; echo $result["cTicketLastChange"]; echo '</div>';
						
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label" >Status</label>';
					echo '<div class="col-sm-8">';
						echo '<div class="control-txt">';
						
							/** display ticket status */
							echo $result["cStatusName"];
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Datei</label>';
					echo '<div class="col-sm-8" class="form-control">';	
					
						/**
						 * display ticketfile
						 * 
						 */
					
						/** get tickefile */
			           	$stmt = getTicketfile($ticketID);
			           	
			           	/** get rowcount of listing */
			           	$rowcount = $stmt->rowCount();
			           	
			           	/**
			           	 * if a ticketfile exists, fetch it an display it.
			           	 * if it does not exist, show them a error
			           	 */
			           	if($rowcount > 0)
			           	{
			           		$rfile = $stmt->fetch(); 
				           	$filepath = $rfile["cFilePath"];
				           	$filename = $rfile["cFileName"];
			    			echo '<div class="control-txt"><a href="./'. $filepath.'" target="_blank" >'.$filename.'</a></div>';		
			           	}
			           	else 
			           	{	/** file-error */
			           		echo '<div class="control-txt"> Keine Datei vorhanden</div>';
			           	}
			           	
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<div class="col-sm-8">';
					echo '</div>';
					echo '<div class="col-sm-2">';
					echo '<a class="btn btn-default btn-block" href="index.php" role="button">Zurück</a>';
					echo '</div>';
				echo '</div>';
			echo '</form>';
		echo '</div>';
	}
}
else 
{
	/** ticket-error */
	echo '<div class="container"><div class="alert alert-danger"><strong>Error: </strong>Es existiert kein Ticket mit dieser Referenznummer.</div></div>';
}
?>
<script type="text/javascript">
$(function () 
{
	$('#datetimepicker2').datetimepicker(
	{
		format: 'YYYY-MM-DD HH:mm:ss',
		locale: moment.locale('de')
	});
	$('#datetimepicker2').data("DateTimePicker").ignoreReadonly(true);

	$('#datetimepicker3').datetimepicker(
	{
		format: 'YYYY-MM-DD HH:mm:ss',
		locale: moment.locale('de')
	});
	$('#datetimepicker3').data("DateTimePicker").ignoreReadonly(true);
});
</script>   