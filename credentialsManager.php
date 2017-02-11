<?php
$fn="testwrite.txt" ;
$myfile = fopen($fn, "w") or die("Unable to open file!".fn);

require 'session/sessionManager.php';
require 'functionalities.php';
$method = $_SERVER['REQUEST_METHOD'];
$userData = $_POST;
//print_r($userData);
$schoolDb = DataBase::getInstance();
$var  = $schoolDb -> checkLogInCredentials ('admins',$userData['email'], $userData['pass']);

fwrite($myfile, '$var= ');
fwrite($myfile, print_r($var, TRUE));
fclose($myfile);
//var_dump($var);

if(!empty($var)){
	$_SESSION["user"] = $var;
}



echo json_encode ($var);


?>