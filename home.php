<link rel="stylesheet" href="css/home.css">
<?php
$title = "Home | To The Top School";
require 'functionalities.php'; 
require 'header.php';
require 'navigation-bar.php';
?>
<div class="centered">
	 <div class="row">
		  <div id="courses" class="col-sm-2">
			<div class="col-title">
				<p>Courses</p>
				<span id="addCourse"data-toggle="modal" data-target="#modal2"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
				</div>
				<div id="coursesList" class="col-content">
						
				</div>	
			</div> 
		<div id="students" class="col-sm-2">
		 	<div class="col-title">
		 		<p>Students</p>
				<span id="addStudent" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
		    </div>
			<div id="studentsList" class="col-content">
					
			</div>	
		</div>
		<div id="main-container" class="col-sm-7">
			<!--<div id='main-inner-ctr'>
				<div id='ctr-header'>
					<h3>Student Name:</h3>
				</div>
				<div id='ctr-img'>
				</div>
				<div id='students-details'>
					<p>Eran Malka<span></span></p>
					<p>0543499302<span></span></p>
					<p>em9101@gmail.com<span></span></p>
				</div>	
				<div id="student-courses-list">
					<ol>
						<li>JAVA</li>
						<li>PHP</li>
						<li>Angular</li>
						<li>C++</li>
					</ol>
				</div>	
		 </div>-->
	</div>
</div>

<?php
require 'modal/AddStudentModal.html';
require 'modal/AddcourseModal.html';
?>

<script src="scripts/home.js"></script>
<script>
	(function(){
		ajaxCall(buildStudentsCol,'studentsManager.php');
		ajaxCall(buildCoursesCol, 'coursesManager.php');
		
	})();
</script>

<?php
require 'footer.php';
?>