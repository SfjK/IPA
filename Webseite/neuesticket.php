<?php
/**
 * create a new ticket
 */

/** variables */
$title = "TSW │ Neues Ticket erfassen";
$header = "normal";
$navbar = 1;

$ticketError = "";
$dateError = "";
$ticketTitle = "";
$ticketDesc = "";
$dateOk = "";

/** includes */
include ('include/header.inc.php');
include ('include/dbconnection.inc.php');
include ('include/pdoclass.inc.php');
include ('include/checkauth.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/navigation.inc.php');
include ('include/sendmail.inc.php');
include ('include/footer.inc.php');

/** post-back actions */
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	/** variables */
	$ticketTitle = $_POST["ticket-title"];
	$ticketkategorieid = $_POST["ticket-thema"];
	$ticketDesc = $_POST["ticket-beschreibung"];
	$ticketDeadline = $_POST["ticket-endtermin"];

	/** strip variables */
	$ticketTitle = strip_tags($ticketTitle);
	$ticketDesc = strip_tags($ticketDesc);
	
	/** get current date and deadline */
	$currentDate = date('Y-m-d H:i:s');
	$checkDeadline = $_POST["ticket-endtermin"];
	$dateOk = 1;
	
	/** 
	 * check if deadline is in the future
	 * if not, display a error 
	 */
	if(empty($checkDeadline))
	{
		$dateOk = 1;
	}
	elseif ($checkDeadline < $currentDate)
	{
		/** display error */
		$dateError = "<div class='alert alert-danger'>Die Deadline kann nicht vor dem Erstellungsdatum des Tickets liegen</div>";
		$dateOk = 0;
	}

	/**
	 * check deadline is ok
	 * check which button was posted
	 */
	if ($dateOk == 1)
	{
		/** get connection */
		$con=dbConn::getConnection();
		
		/** save ticket and redirect to detailview */
		if(isset($_POST['save-ticket']))
		{
			$ticketError = createNewTicket($con, $_FILES);
			
			/** if no error exists, redirect to ticket */
			if (empty($ticketError))
			{
				$stmt = $con->prepare('SELECT * FROM ttickets WHERE cOwnerID=:ticketowner ORDER BY cTicketID DESC LIMIT 1');
				$stmt->bindParam(':ticketowner', $userid, PDO::PARAM_STR);		
				$stmt->execute();
				$result = $stmt->fetch();
				$lastTicketId = $result[cTicketID];
				header("Location: ticket_details.php?id=$lastTicketId");		
			}
		}
		
		/** save ticket and go back to index.php */
		if(isset($_POST['save-goback']))
		{
			$ticketError = createNewTicket($con, $_FILES);
			
			/** if no error exists, redirect to index.php */
			if (empty($ticketError))
			{
				header("Location: index.php");
			}
		}
	}
}
?>
<!-- html -->
<div class="container">
	<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<h2 class="col-md-3 control-label">Neues Ticket</h2>     	
		</div>
		<!-- titel -->
		<div class="form-group">
			<label class="col-sm-2 control-label">Titel *</label>
			<div class="col-sm-8">
                <input class="form-control" id="focusedInput" name="ticket-title" value="<?php echo $ticketTitle; ?>" type="text" required>
            </div>            	
		</div>    
		<!-- category -->
		<div class="form-group">
        	<label class="col-sm-2 control-label">Thema *</label>
	        <div class="col-sm-8">
		        <select class="form-control" name="ticket-thema" required>
		        <?php 
		        /** get all categories for listing */
		        $rkategorie = getEveryCategory();
		        
		        /** write them into dropdown box */
		        foreach ($rkategorie as $key => $row)
		        {
		        	echo '<option value="'.$row['cKategorieID'].'">'.$row['cKategorieName'].'</option>';	
		        }
		        ?>
		        </select>
	        </div>                        	
		</div>   	
		<!-- description -->
		<div class="form-group">
			<label class="col-sm-2 control-label">Beschreibung *</label>
            <div class="col-sm-8">
            	<textarea class="form-control" rows="5" name="ticket-beschreibung" id="comment" required><?php echo $ticketDesc; ?></textarea>
            </div>
		</div>
		<!-- deadline -->
        <div class="form-group">
	        <label class="col-sm-2 control-label">Endtermin</label>
	        <div class="col-sm-7">
		        <div class="input-group date" id="datetimepicker2">
			        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-endtermin" readonly/>
			        <span class="input-group-addon">
			        	<span class="glyphicon glyphicon-calendar"></span>
			        </span>
		        </div>
	        </div>
	        <!-- reset deadline button -->
	       	<div class="col-sm-1">
				<button class="btn btn-default btn-block" type="button" onClick="resetEndtermin(); return false;">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
        </div>
        <!-- file -->
        <div class="form-group">
        	<label class="col-sm-2 control-label">Datei</label>
           	<div class="col-sm-8">
    			<input type="file" name="fileToUpload" id="fileToUpload">
            </div>
		</div>
		<!-- buttons -->
		<div class="form-group" >
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<button class="btn btn-primary btn-block" name="save-goback" type="submit">Speichern und Zurück</button>
			</div>
			<div class="col-sm-2">
				<button class="btn btn-default btn-block" name="save-ticket" type="submit">Speichern</button>
			</div>
			<div class="col-sm-2">
				<a class="btn btn-default btn-block" href="index.php" role="button">Zurück</a>
			</div>
		</div>
		<!-- error display -->
		<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-8"><?php echo $dateError; ?></div>
		</div>
		<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-8"><?php echo $ticketError; ?></div>
		</div>
	</form>
</div>
<!-- scripts -->
<script type="text/javascript">
$(function () 
{
	$('#datetimepicker2').datetimepicker(
	{
		format: 'YYYY-MM-DD HH:mm:ss',
		locale: moment.locale('de'),
		toolbarPlacement: 'top'
	});
	$('#datetimepicker2').data("DateTimePicker").ignoreReadonly(true);
});
</script>   