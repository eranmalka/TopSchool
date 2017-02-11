<?php
require 'functionalities.php';
$fn="coursemanager.txt" ;
$myfile = fopen($fn, "w") or die("Unable to open file!".fn);

$schoolDb = DataBase::getInstance();

$method = $_SERVER['REQUEST_METHOD'];
$request = [];
// studentsManager.php/12 - {studentId}/dddd/aaaa/ --> [12,"dddd","aaaa"]
if(!empty($_SERVER['PATH_INFO'])){
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}
$key = array_shift($request)+0;

$schoolDb = DataBase::getInstance();
	//echo json_encode ($schoolDb -> getData ("courses1"));
switch ($method) {
  case 'GET': 
	if(empty($key)){
		echo json_encode ($schoolDb -> getData ("courses1"));
	}
	else {
		$courseInfo = $schoolDb -> getDataId("courses1",$key);
		$courseInfo['students'] = $schoolDb -> getAllStudentsInCourse($key);
		echo json_encode ($courseInfo);
	}
	break;
  case 'POST':
		$schoolDb -> insertData2 ("courses1", $_POST);
		break;
  case 'PUT':
        if(empty($key)){
            echo json_encode('please send id');
            break;
        } 
		$input = file_get_contents('php://input');
        parse_str($input, $params);
		echo $schoolDb -> updateCourse('courses1', $key, $params);
		break;
  case 'DELETE':
		if(empty($key)){
			echo json_encode('please send id');
			break;
		} 
		$schoolDb -> deleteCourse('courses1', $key);
		break;
}




?>