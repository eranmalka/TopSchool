<?php
require 'functionalities.php';
$method = $_SERVER['REQUEST_METHOD'];
$userData = $_POST;
//print_r($userData);
$schoolDb = DataBase::getInstance();
$var  = $schoolDb -> checkLogInCredentials ('admins',$userData['email'], $userData['pass']);
//print_r($var);
echo json_encode ($var);


?>