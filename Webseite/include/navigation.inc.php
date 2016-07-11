<?php 

/** database connection for counting tickets */
$query = "SELECT COUNT(*) FROM ttickets WHERE cStatusID=1 OR cStatusID=2 OR cStatusID=3 OR cStatusID=6";
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
	/** navbar for administrator */
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
            
            /** navbar left */
           	echo '<div class="collapse navbar-collapse" id="myNavbar">';
                echo '<ul class="nav navbar-nav">';
                    echo '<li>';
                    
                    	/** summ of tickets */
                    	echo '<a href="index.php"><span class="glyphicon glyphicon-home"></span> Ticketübersicht ';
                        	echo '<span class="badge">';
								echo $ticketsum;								
                    		echo '</span>';
                       	echo '</a>';
                       	
                    echo '</li>';
                    echo '<li>';
                    	
                    	/** create ticket */
                    	echo '<form action="neuesticket.php">';
                    		echo '<button class="btn btn-primary navbar-btn">';
                    			echo '<span class="glyphicon glyphicon-plus"></span> Ticket erfassen';
                    		echo '</button>';
                    	echo '</form> ';
                    	
                    echo '</li>';                   
                echo '</ul>';
                
                /** navbar right */
               	echo '<ul class="nav navbar-nav navbar-right">';
                	echo '<li>';
                	
                		/** manual */
                        echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span> Hilfe</a>';
                    
                    echo '</li>';
                    echo '<li>';
                    
                    	/** profile */
                    	echo '<a href="profil.php"><span class="glyphicon glyphicon-user"></span>';             
                    		echo " {$userVorname}  {$userNachname}";  
                    	echo'</a>';
                    	
                    echo '</li>';
                    echo '<li class="dropdown">';
                  		
                    	/** usermanager */
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
                    
                    	/** logout */
                    	echo '<a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log-Out</a>';
                    	
                    echo '</li>';
                echo '</ul>';
            echo '</div>';
        echo '</div>';
    echo '</nav>';
}	
if ($navbar === 2)
{
	/** navbar for normal users */
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
			
				/** navbar left */
	        	echo '<ul class="nav navbar-nav">';
					echo '<li>';
					
						/** summ of tickets */
						echo '<a href="index.php"><span class="glyphicon glyphicon-home"></span> Ticketübersicht ';
							echo '<span class="badge">';
								echo $ticketsum;	
							echo '</span>';
						echo '</a>';
						
					echo '</li>';										
					echo '<li>';
					
						/** create ticket */
                    	echo '<form action="neuesticket.php">';
                    		echo '<button class="btn btn-primary navbar-btn">';
                    			echo '<span class="glyphicon glyphicon-plus"></span> Ticket erfassen';                   			
                    		echo '</button>';
                    	echo '</form> ';
                    	
                    echo '</li>';
				echo '</ul>';
				
				/** navbar right */
				echo '<ul class="nav navbar-nav navbar-right">';
	            	echo '<li>';
	            	
	            		/** manual */
	            		echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span>	Hilfe</a>';
	            		
	            	echo '</li>';
	            	echo '<li>';
	            	
	            		/** profile */
	                	echo '<a href="profil.php"><span class="glyphicon glyphicon-user"></span>';	                		                		
	                		echo " {$userVorname}  {$userNachname}"; 	                		
	                	echo'</a>';
	                	
	                echo '</li>';
	                echo '<li>';
	                	
	                	/** logout */
	                	echo '<a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log-Out</a>';
	                	
	                echo '</li>';
	            echo '</ul>';
	        echo '</div>';
	    echo '</div>';
	echo '</nav>';
}
if ($navbar === 3)
{
	/** navbar for login/logout */
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
					
						/** manual */
						echo '<a href="manual/Benutzerhandbuch.pdf" target="_blank"><span class="glyphicon glyphicon-file"></span> Hilfe</a>';
						
					echo '</li>';
				echo '</ul>';
			echo '</div>';
		echo '</div>';   
	echo '</nav>';
}
?>