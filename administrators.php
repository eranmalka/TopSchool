<?php
require 'session/sessionManager.php';
?>
<link rel="stylesheet" href="css/administrations.css">
<?php
$title = "Administration | To The Top School";
require 'functionalities.php'; 
require 'header.php';
require 'navigation-bar.php';
?>

<div class="centered">
	 <div class="row">
		  <div id="courses" class="col-sm-2">
			<div class="col-title">
				<p>Administrators</p>
				<span id="addAdmin"data-toggle="modal" data-target="#modal"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
				</div>
				<div id="adminlist" class="col-content">
				
				</div>	
			</div> 
		<div id="main-container" class="col-sm-7">
			
		</div>
</div>
</div>
<?php
require 'modal/Addadministrator.html';
?>

<script src="scripts/admin.js"></script>
<script>
(function(){
	getAllAdmins(buildAdmin, 'administratorsManager.php');
	
})();
	
	
</script>

<?php
	require 'footer.php';
?>
			
			