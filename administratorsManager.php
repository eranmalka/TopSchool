<?php
require 'functionalities.php';

$schoolDb = DataBase::getInstance();
$method = $_SERVER['REQUEST_METHOD'];
$key = null;





switch ($method) {
  case 'GET': 
	if(empty($key)){
		echo json_encode($schoolDb -> getData ("admins"));
	}else{
		echo json_encode($schoolDb -> getDataId ("student_course",$key));
	}
	break;
  case 'POST'://insert students details
	$data = $schoolDb -> insertAdminToDb ("admins", $_POST);
	break;
}


?>