<link rel="stylesheet" href="css/nav.css">
  <div class="jumbotron jumbotron-adding">
	  <div class="logo-image"></div> 
	  <div id="nav-links">
		  <?php				  
		  if(empty($_SESSION["user"])){  
			       echo '<span></span>';
			    }else if ($_SESSION["user"]['role'] == 'sales'){
					echo '<a href = "home.php"><span>School</span></a>';	
				}else if ($_SESSION["user"]['role'] == 'owner'){
					echo '<a href = "home.php"><span>School</span></a> | <a href = "administrators.php"><span>Administration</span></a>';
				}else if ($_SESSION["user"]['role'] == 'manager'){
					echo '<a href = "home.php"><span>School</span></a> | <a href = "administrators.php"><span>Administration</span></a>';
				}else{
					echo '<p><p>';
				}
			?>
	  </div>
	  <div class="nav-user-details">
		  <div>
			<?php if(isset($_SESSION["user"])) { 
				echo '<p>'.$_SESSION["user"]['name'] .'<span>' .$_SESSION["user"]['role'].'</span></p>';
				echo '<p><a href="/project-3-5/session/killsession.php">Logout</a></p>';
	 			echo '</div>';  
				echo '<div style="background-image:url('.$_SESSION["user"]['image'].')"></div>';
			} 
			  else {
			  	echo '<p>Hello Guest</p>';
			 	echo '<p><a href="/project-3-5/login.php">Login</a></p>';
			    echo '</div>';  
				echo '<div></div>';
			  }
			
			  ?>
		  
	  </div>
	  <div style="clear:both;"></div>
  </div>
