<?php
/** variables */
$title = "TSW │ Neues Ticket erfassen";
$header = "normal";
$navbar = 1;

$ticketError = "";
$dateError = "";
$ticketTitle = "";
$ticketDesc = "";
$createMessage = "";
$dateOk = "";

/** includes */
include ('include/header.inc.php');
include ('include/dbconnection.inc.php');
include ('include/pdoclass.inc.php');
include ('include/checkauth.inc.php');
include ('include/functioncontroller.inc.php');
include ('include/navigation.inc.php');
include ('include/footer.inc.php');
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
		        $con=dbConn::getConnection();
		        $stmt = $con->prepare('SELECT cKategorieID, cKategorieName FROM tkategorie');
		        $stmt->execute();
		        $rkategorie = $stmt->fetchAll(PDO::FETCH_ASSOC); //gibt array zurück
		        
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
	        <div class="col-sm-8">
		        <div class="input-group date" id="datetimepicker2">
			        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="ticket-endtermin"/>
			        <span class="input-group-addon">
			        	<span class="glyphicon glyphicon-calendar"></span>
			        </span>
		        </div>
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
				<button class="btn btn-primary btn-block" name="save-goback" type="submit">Speichern und Schliessen</button>
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
	});
});
</script>   