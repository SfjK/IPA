<?php
/** 
 * define standard values for filtering
 * % used for sql
 */
$fTicketKategorie = "%";
$fTicketStatus = array(1,2,3,4,6);
$fTicketOwner = "%";
$fTicketSupporter = "%";
$sTicketKategorie = '0';
$sTicketStatus = '0';
$sTicketOwner = '0';
$sTicketSupporter = '-1';
	
/** post-back for the ticketfilter */
if(isset($_POST['filter-ticket']))
{
	/** get post */
	$fTicketKategorie = $_POST["ticketkategorie"];
	$fTicketStatus = $_POST["ticketstatus"];
	$fTicketOwner = $_POST["ticketowner"];
	$fTicketSupporter = $_POST["ticketsupporter"];	
	$sTicketKategorie = $_POST["ticketkategorie"];
	$sTicketStatus = $_POST["ticketstatus"];
	$sTicketOwner = $_POST["ticketowner"];
	$sTicketSupporter = $_POST["ticketsupporter"];
	
	/** 
	 * define values for filtering 
	 * % used for sql
	 */
	if ($fTicketKategorie == 0)
	{
		$fTicketKategorie = "%";
	}
	 
	if ($fTicketStatus == 0)
	{
		$fTicketStatus = array(1,2,3,4,6);
	}
	else
	{
		$fTicketStatus = array($fTicketStatus);
	}
	 
	if ($fTicketOwner == 0)
	{
		$fTicketOwner = "%";
	}
	 
	if ($fTicketSupporter == -1)
	{
		$fTicketSupporter = "%";
	}
}
?>
<!-- ticketfilter html structure -->
<div class="container">
	<form class="form-horizontal" role="form" method="post">
		<div class="form-group">
			<h2 class="col-md-3 control-label">Ticketübersicht</h2>
		</div>
		<div class="form-group form-group">
			<div class="col-sm-3">
				<label for="tfkategorie">Kategorie</label> 
				<select class="form-control" id="tfkategorie" name="ticketkategorie">
					<?php 
					/** Get every Category from DB */
			        $fKategorie = getEveryCategory();
			        
			        /** Define standard option for all categories */
			        echo '<option value="0">Alle</option>';
			        
			        /** List categories from DB */
			        foreach ($fKategorie as $key => $row)
			        {
			        	echo '<option value="'.$row['cKategorieID'].'"';
			        		if ($row["cKategorieID"]==$sTicketKategorie) echo 'selected="selected"';
			        	echo '>'.$row['cKategorieName'].'</option>';	
			        }				       
		        	?>
				</select>
			</div>
			<div class="col-sm-3">
				<label for="tfstatus">Status</label> 
				<select class="form-control" id="tfstatus" name="ticketstatus">
					<?php 
					/** Get every status from DB */
					$fStatus = getEveryStatus();
					
			        /** Define standard option for all active tickets */
			        echo '<option value="0">Alle Aktiven</option>';
			        
			        /** List status from DB */
			        foreach ($fStatus as $key => $row)
			        {
			        	echo '<option value="'.$row['cStatusID'].'"';
			        		if ($row["cStatusID"]==$sTicketStatus) echo 'selected="selected"';
			        	echo '>'.$row['cStatusName'].'</option>';	
			        }
		        	?>
				</select>
			</div>
			<div class="col-sm-2">
				<label for="tfcreator">Ersteller</label> 
				<select class="form-control" id="tfcreator" name="ticketowner">
					<?php 
					/** Get every user except standard user from DB */
					$fCreator = getEveryUserWithoutUser0();
					
			        /** Define standard option for all creators */
			        echo '<option value="0">Alle</option>';
			        
			        /** List creators from DB */
			        foreach ($fCreator as $key => $row)
			        {
			        	echo '<option value="'.$row['cBenutzerID'].'"';
			        		if ($row["cBenutzerID"]==$sTicketOwner) echo 'selected="selected"';
			        	echo '>'.$row['cUsername'].'</option>';	
			        }
		        	?>
				</select>
			</div>
			<div class="col-sm-2">
				<label for="tfsupporter">Supporter</label> 
				<select class="form-control" id="tfsupporter" name="ticketsupporter">
					<?php 
					/** Get every admin from DB */
			        $fSupporter = getEveryAdmin();
			        
			        /** Define standard option for all admins */
			        echo '<option value="-1">Alle</option>';
			        
			        /** List admins from DB */
			        foreach ($fSupporter as $key => $row)
			        {
			        	echo '<option value="'.$row['cBenutzerID'].'"';
			        		if ($row["cBenutzerID"]==$sTicketSupporter) echo 'selected="selected"';
			        	echo '>'.$row['cUsername'].'</option>';	
			        }
		        	?>
				</select>
			</div>
			<div class="col-sm-2">
				<label for="tfsuchen">Filtern</label>
				<button class="btn btn-block btn-primary" name="filter-ticket" id="tfsuchen" type="submit">
					<span class="glyphicon glyphicon-filter"></span>
				</button>
			</div>
		</div>
	</form>
</div>