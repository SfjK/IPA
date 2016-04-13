<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$ticketTitle = $_POST["ticket-title"];
	$ticketkategorieid = $_POST["ticket-thema"];
	$ticketDesc = $_POST["ticket-beschreibung"];
	$ticketDeadline = $_POST["ticket-endtermin"];

	$ticketTitle = strip_tags($ticketTitle);
	$ticketDesc = strip_tags($ticketDesc);

	$currentDate = date('Y-m-d H:i:s');
	$checkDeadline = $_POST["ticket-endtermin"];

	$dateOk = 1;
	if(empty($checkDeadline))
	{
		$dateOk = 1;
	}
	elseif ($checkDeadline < $currentDate)
	{
		$dateError = "<div class='alert alert-danger'>Die Deadline kann nicht vor dem Erstellungsdatum des Tickets liegen</div>";
		$dateOk = 0;
	}

	if ($dateOk == 1)
	{
		$con=dbConn::getConnection();
		if(isset($_POST['save-ticket']))
		{
			$ticketError = createNewTicket($con, $_FILES);
			if (empty($ticketError))
			{
				$stmt = $con->prepare('SELECT * FROM ttickets WHERE cOwnerID=:ticketowner');
				$stmt->bindParam(':ticketowner', $userid, PDO::PARAM_STR);
				$last_ticketid = $con->lastInsertId();
				$stmt->execute();
				header("Location: ticket_details.php?id=$last_ticketid");		
			}
		}

		if(isset($_POST['save-goback']))
		{
			$ticketError = createNewTicket($con, $_FILES);
			if (empty($ticketerror))
			{
				header("Location: index.php");
			}
		}
	}
}
?>

<div class="container">
	<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<h2 class="col-md-3 control-label">Neues Ticket</h2>     	
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Titel *</label>
			<div class="col-sm-8">
                <input class="form-control" id="focusedInput" name="ticket-title" value="<?php echo $ticketTitle; ?>" type="text" required>
            </div>            	
		</div>    
		<div class="form-group">
        	<label class="col-sm-2 control-label" >Thema *</label>
	        <div class="col-sm-8">
		        <select class="form-control" name="ticket-thema" required>
		        <?php 
		        $rkategorie = getEveryCategory();
		        
		        foreach ($rkategorie as $key => $row)
		        {
		        	echo '<option value="'.$row['cKategorieID'].'">'.$row['cKategorieName'].'</option>';	
		        }
		        ?>
		        </select>
	        </div>                        	
		</div>   	
		<div class="form-group">
			<label class="col-sm-2 control-label">Beschreibung *</label>
            <div class="col-sm-8">
            	<textarea class="form-control" rows="5" name="ticket-beschreibung" id="comment" required><?php echo $ticketDesc; ?></textarea>
            </div>
		</div>
        <div class="form-group">
	        <label class="col-sm-2 control-label">Endtermin</label>
	        <div class="col-sm-7">
		        <div class="input-group date" id="datetimepicker2" >
			        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-endtermin" readonly/>
			        <span class="input-group-addon">
			        	<span class="glyphicon glyphicon-calendar"></span>
			        </span>
		        </div>
	        </div>
	       	<div class="col-sm-1">
				<button class="btn btn-default btn-block" type="button" onClick="resetEndtermin(); return false;">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">Datei</label>
           	<div class="col-sm-8">
    			<input type="file" name="fileToUpload" id="fileToUpload">
            </div>
		</div>
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