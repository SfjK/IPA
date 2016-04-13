<?php 

/** database connection for counting tickets */
$query = "SELECT COUNT(*) FROM ttickets";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ticketsum);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
	
/**
 * Select correct navbar, dependent on $navbar value
 * 1 = administrator
 * 2 = user
 * 3 = login
 */
if ($navbar === 1)
{
	echo '<nav class="navbar navbar-default navbar-fixed-top">';
        echo '<div class="container-fluid">';
            echo '<div class="navbar-header">';
            	echo '<form role="form">';
                	echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">';
                    	echo '<span class="icon-bar"></span>';
                    	echo '<span class="icon-bar"></span>';
                    	echo '<span class="icon-bar"></span>';
                	echo '</button>';
				echo '</form>';
                echo '<a href="index.php"><img src="logo/swissbanking_logo_183_27.png" alt="Swissbanking" />';
                echo '</a>';
            echo '</div>';
           	echo '<div class="collapse navbar-collapse" id="myNavbar">';
                echo '<ul class="nav navbar-nav">';
                    echo '<li>';
                    	echo '<a href="../index.php"><span class="glyphicon glyphicon-home"></span> Ticketübersicht ';
                        	echo '<span class="badge">';
                        	
                        		/** summ of tickets */
								echo $ticketsum;
								
                    		echo '</span>';
                       	echo '</a>';
                    echo '</li>';
                    echo '<li>';
                    	echo '<form action="neuesticket.php">';
                    		echo '<button class="btn btn-primary navbar-btn">';
                    			echo '<span class="glyphicon glyphicon-plus"></span> Ticket erfassen';
                    		echo '</button>';
                    	echo '</form> ';
                    echo '</li>';                   
                echo '</ul>';            
               	echo '<ul class="nav navbar-nav navbar-right">';
                	echo '<li>';
                        echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span> Hilfe</a>';
                    echo '</li>';
                    echo '<li>';
                    	echo '<a href="profil.php"><span class="glyphicon glyphicon-user"></span>';
                    		/** Username */
                    		echo " {$userVorname}  {$userNachname}";  
                    	echo'</a>';
                    echo '</li>';
                    echo '<li class="dropdown">';
                    	echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                    		echo '<span class="glyphicon glyphicon-cog"></span> Usermanager';
                    		echo '<span class="caret"></span>';
                   		echo '</a>';
                    	echo '<ul class="dropdown-menu">';
                    		echo '<li><a href="neuernutzer.php">Neuer Nutzer</a></li>';
                    		echo '<li><a href="usermanagement.php">Übersicht</a></li>';
                    	echo '</ul>';
                    echo '</li>';
                    echo '<li>';
                    	echo '<a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log-Out</a>';
                    echo '</li>';
                echo '</ul>';
            echo '</div>';
        echo '</div>';
    echo '</nav>';
}	
if ($navbar === 2)
{
	echo '<nav class="navbar navbar-default navbar-fixed-top">';
		echo '<div class="container-fluid">';
			echo '<div class="navbar-header">';
				echo '<form role="form">';
					echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">';
                    	echo '<span class="icon-bar"></span>';
                    	echo '<span class="icon-bar"></span>';
                    	echo '<span class="icon-bar"></span>';
	                echo '</button>';
				echo '</form>';
				echo '<a href="index.php"><img src="logo/swissbanking_logo_183_27.png" alt="Swissbanking" /></a>';   
			echo '</div>';
			echo '<div class="collapse navbar-collapse" id="myNavbar">';
	        	echo '<ul class="nav navbar-nav">';
					echo '<li>';
						echo '<a href="index.php"><span class="glyphicon glyphicon-home"></span> Ticketübersicht ';
							echo '<span class="badge">';
							
								/** summ of tickets */
								echo $ticketsum;	
								
							echo '</span>';
						echo '</a>';
					echo '</li>';
					 echo '<li>';
                    	echo '<form action="neuesticket.php">';
                    		echo '<button class="btn btn-primary navbar-btn">';
                    			echo '<span class="glyphicon glyphicon-plus"></span> Ticket erfassen';
                    		echo '</button>';
                    	echo '</form> ';
                    echo '</li>';
				echo '</ul>';
				echo '<ul class="nav navbar-nav navbar-right">';
	            	echo '<li>';
	            		echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span>	Hilfe</a>';
	            	echo '</l>';
	            	echo '<li>';
	                	echo '<a href="profil.php"><span class="glyphicon glyphicon-user"></span>';
	                	
	                		/** username */
	                		echo " {$userVorname}  {$userNachname}"; 
	                		
	                	echo'</a>';
	                echo '</li>';
	                echo '<li>';
	                	echo '<a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log-Out</a>';
	                echo '</li>';
	            echo '</ul>';
	        echo '</div>';
	    echo '</div>';
	echo '</nav>';
}
if ($navbar === 3)
{
	echo '<nav class="navbar navbar-default navbar-fixed-top">';
		echo '<div class="container-fluid">';
			echo '<div class="navbar-header">';
				echo '<form role="form">';
					echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">';
       					echo '<span class="icon-bar"></span>';
        				echo '<span class="icon-bar"></span>';
        				echo '<span class="icon-bar"></span>';
					echo '</button>';
				echo '</form>';
				echo '<a href="login.php"><img src="logo/swissbanking_logo_183_27.png" alt="Swissbanking" /></a>';
			echo '</div>';
			echo '<div class="collapse navbar-collapse" id="myNavbar">';
				echo '<ul class="nav navbar-nav navbar-right">';
					echo '<li>';
						echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span> Hilfe</a>';
					echo '</li>';
				echo '</ul>';
			echo '</div>';
		echo '</div>';   
	echo '</nav>';
}
?>