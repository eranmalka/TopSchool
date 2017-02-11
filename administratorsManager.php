<?php
require 'functionalities.php';

$request = [];

if(!empty($_SERVER['PATH_INFO'])){
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}
$key = array_shift($request)+0;

$schoolDb = DataBase::getInstance();
$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
  case 'GET': 
	if(empty($key)){
		echo json_encode($schoolDb -> getData ("admins"));
	}else{
		echo json_encode($schoolDb -> getDataId ("admins",$key));
	}
	break;
  case 'POST'://insert students details
	$data = $schoolDb -> insertAdminToDb ("admins", $_POST);
	break;
  case 'DELETE'://insert students details
	$schoolDb -> deleteAdmin("admins", $key);
	break;
  case 'PUT':
        if(empty($key)){
            echo json_encode('please send id');
            break;
			} 
		$input = file_get_contents('php://input');
		parse_str($input, $params);
		echo $schoolDb -> updateAdmin('admins', $key, $params);
		break;

}
?>