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
		echo json_encode($schoolDb -> getData ("student_course"));
	}else{
		echo json_encode($schoolDb -> getDataId ("student_course",$key));
	}
	break;
  case 'POST'://insert students details
	
		$data = $schoolDb -> insertData ("students", $_POST);
		$studentCourses = [];
		$studentId = $data['id'];
		foreach($data['courses'] as $courseNumber){
			$student = [];
			$student['student_id'] = $studentId;
			$student['course_id'] = $courseNumber;
			array_push($studentCourses,$student);
			printingToFile($studentCourses);
		}
		echo 'this is studentcourses' .$schoolDb -> insertStudentCourses ($studentCourses);
		break;
}
?>