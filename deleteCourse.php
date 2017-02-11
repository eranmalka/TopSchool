<?php
require 'functionalities.php';


$method = $_SERVER['REQUEST_METHOD'];
$request = [];
// studentsManager.php/12 - {studentId}/dddd/aaaa/ --> [12,"dddd","aaaa"]
if(!empty($_SERVER['PATH_INFO'])){
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}
$key = array_shift($request)+0;

$schoolDb = DataBase::getInstance();

switch ($method) {
  case 'GET': 
	if(empty($key)){
		echo json_encode ($schoolDb -> getData ("students"));
	}
	else {
		$studentIno = $schoolDb -> getDataId("students",$key);
		$studentIno['courses'] = $schoolDb -> getAllStudentCourses($key);
		echo json_encode ($studentIno);
	}
	break;
  case 'POST':
		print_r($_POST);
		$schoolDb -> deleteCourse('courses1', $_POST['id']);
		}
		
?>