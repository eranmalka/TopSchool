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

/**
 GET
 	/studentsManger.php
	/studentsManger/{id}
 POST
 	/studentsManger.php
 PUT
 	/studentsManger.php/{id}
 DELETE
 	/studentsManger.php/{id}
 PATCH 
 	/studentsManger.php/{id} 
 	
*/

switch ($method) {
  case 'GET': 
	if(empty($key)){
		echo json_encode ($schoolDb -> getData ("students"));
	}
	else {
		echo json_encode ($schoolDb -> getDataId("students",$key));
	}
	break;
  case 'POST':
		print_r($_POST);
		$data = $schoolDb -> insertData ("students", $_POST);
		print_r("return student id" .$data['id']);
		$studentCourses = [];
		$studentId = $data['id'];
		print_r('$data[courses] = ');
		print_r($data['courses']);
		foreach($data['courses'] as $courseNumber){
			$student = [];
			$student['student_id'] = $studentId;
			$student['course_id'] = $courseNumber;
			array_push($studentCourses,$student);
		}
		echo $schoolDb -> insertStudentCourses ($studentCourses);
		break;
}
?>