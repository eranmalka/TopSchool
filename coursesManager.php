<?php
require 'functionalities.php';
//function that conveert data from mysql to utf8



$schoolDb = DataBase::getInstance();
//
///
//
//
////

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
		echo json_encode ($schoolDb -> getDataId("courses1",$key));
	}
	break;
  case 'POST':
		$schoolDb -> insertData2 ("courses1", $_POST);
		break;
}



?>