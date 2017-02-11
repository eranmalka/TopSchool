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
		$data = $schoolDb -> insertData ("students", $_POST);
		$studentCourses = [];
		$studentId = $data['id'];
		foreach($data['courses'] as $courseId){
			$student = [];
			$student['student_id'] = $studentId;
			$student['course_id'] = $courseId;
			array_push($studentCourses,$student);
		}
		echo $schoolDb -> insertStudentCourses ($studentCourses);
		break;
	case 'PUT':
			if(empty($key)){
				echo json_encode('please send id');
				break;
			} 
		$input = file_get_contents('php://input');
		parse_str($input, $params);
		echo $schoolDb -> updateStudent('students', $key, $params);
		break;
  case 'DELETE':
		if(empty($key)){
			echo json_encode('please send id');
			break;
		} 
		$schoolDb -> deleteStudent('students', $key);
		//$schoolDb -> deleteStudent ("students");
	break;
}
?>