<?php
/** get tickets for listing */
$stmt = getTicketsfForListe($fTicketStatus, $fTicketKategorie, $fTicketOwner, $fTicketSupporter);

/** get rowcount of listing */
$rowcount = $stmt->rowCount();

/**
 * if a ticket exists with the filtercriteria exists, fetch it an display it.
 * if it does not exist, show them a blank list with a hint
 */
if($rowcount > 0)
{
	/** fetch result */
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	/** display ticketlist */
	resultAsTicketliste($result);	
}
else 
{
	/** hint user if no ticket under such criteria exists */
	echo '<div class="container">';
		echo '<table class="table table-hover">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>ID</th>';
					echo '<th>Titel</th>';
					echo '<th>Kategorie</th>';
					echo '<th>Erfasser</th>';
					echo '<th>Supporter</th>';
					echo '<th>Status</th>';
					echo '<th>Deadline</th>';
					echo '<th></th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="3">Kein Ticket erfüllt die ausgewählten Suchkriterien</td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo "<td><a class='btn btn-default btn-xs' role='button' disabled>Ansehen<a/></td>";
				echo '</tr>';
			echo '</tbody>';
		echo '</table>';
	echo '</div>';
}
?>