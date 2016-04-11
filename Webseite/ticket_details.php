<?php
/** variables */
$title = "TSW │ Ticket Detailansicht";
$header = "normal";
$navbar = 1;

/** get ticket id */
$tid = $_GET['id'];

/** includes */
include ('include/header.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/dbconnection.inc.php');
include ('include/pdoclass.inc.php');
include ('include/checkauth.inc.php');
include ('include/navigation.inc.php');
include ('include/sendmail.inc.php');
include ('include/footer.inc.php');

if(isset($_POST['save-ticket']))
{
	
}

/** get ticket */
$stmt = getTicketById($tid);

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
					echo '<label class="col-sm-2 control-label">Erstellungsdatum *</label>';
					echo '<div class="col-sm-8">';
		                echo '<input class="form-control" id="focusedInput" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-erstellungsdatum" type="text" value="';
		                
		                	/** display ticket createdate */
		                	echo $result["cTicketCreateDate"];
		                	
		                echo '" required>';
		            echo '</div>';   	
				echo '</div>';
		        echo '<div class="form-group">';
					echo '<label class="col-sm-2 control-label">Endtermin</label>';
					echo '<div class="col-sm-8">';
		                echo '<input class="form-control" id="focusedInput" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-endtermin" type="text" value="';
		                
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
							
		                echo '">';
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
			           	$stmt = getTickefile();
			           	
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
						echo '<button class="btn btn-primary btn-block" name="save-ticket" action="index.php" type="submit" >Speichern und Zurück</button>';
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
			           	$stmt = getTickefile();
			           	
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