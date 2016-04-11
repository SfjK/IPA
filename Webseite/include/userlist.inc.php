<?php
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, 'SELECT cBenutzerID AS ID, cUsername AS Username, CONCAT(cVorname," ", cNachname) AS Name, trollen.cRolleBeschreibung AS Rolle FROM tbenutzer INNER JOIN trollen ON tbenutzer.cRolle = trollen.cRolle WHERE tbenutzer.cAktiv=1');
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
	
if (mysqli_stmt_num_rows($stmt) > 0)
{
	mysqli_stmt_close($stmt);
	$sql = 'SELECT cBenutzerID AS ID, cUsername AS Username, CONCAT(cVorname," ", cNachname) AS Name, trollen.cRolleBeschreibung AS Rolle FROM tbenutzer INNER JOIN trollen ON tbenutzer.cRolle = trollen.cRolle WHERE tbenutzer.cAktiv=1';
	$result = mysqli_query($conn, $sql);
	$arrayKeys = mysqli_fetch_fields($result);
	
	if (mysqli_num_rows($result) > 0) 
	{
		echo '<div class="container">';
			echo '<div class="table-responsive">';
				echo '<table class="table table-hover">';
				echo '<thead>';
				echo '<tr>';
		        	foreach ($arrayKeys as $key) 
		        	{
		           		echo '<th>'.$key->name.'</th>';
		        	}
					echo "<th></th>";
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
					foreach ($result as $row)
					{
						echo '<tr>';
						foreach ($row as $value)
						{
							echo '<td>'.$value.'</td>';
						}
						echo "<td><a class='btn btn-default btn-xs' role='button' href='benutzer_details.php?id=".$row['ID']."'>Bearbeiten<a/></td>";
						echo '</tr>';
						$detailviewid = $row['ID'];
					}
				echo '</tbody>';
			echo '</table>';
		echo '</div>';
	echo '</div>';
	}
}
else
{
	mysqli_stmt_close($stmt);
	$sql = 'SELECT cBenutzerID AS ID, cUsername AS Username, CONCAT(cVorname," ", cNachname) AS Name, trollen.cRolleBeschreibung AS Rolle FROM tbenutzer INNER JOIN trollen ON tbenutzer.cRolle = trollen.cRolle';
	$result = mysqli_query($conn, $sql);
	$arrayKeys = mysqli_fetch_fields($result);
	
	echo '<div class="container">';
		echo '<table class="table table-hover">';
			echo '<thead>';
				echo '<tr>';
			
		        	foreach ($arrayKeys as $key) 
		        	{
		           		echo '<th>'.$key->name.'</th>';
		        	}
					echo "<th></th>";
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				echo '<tr>';
					echo '<td></td>';
					echo '<td>Es existieren keine Benutzer</td>';
					echo '<td></td>';			
					echo '<td></td>';
					echo '<td></td>';
				echo '</tr>';
			echo '</tbody>';
		echo '</table>';
	echo '</div>';
}
?>