<?php

function printingToFile($val){
//phpinfo();
$fn="testwrite.txt" ;
$myfile = fopen($fn, "w") or die("Unable to open file!".fn);
fwrite($myfile, 'val=');
fwrite($myfile, print_r($val, TRUE));
fclose($myfile);
	
}
class DataBase{
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "to_the_top_school";
	
	private static $instance;
    private $pdo;
	
	public function __construct(){
        
        try{
			// Create a new PDO instanace
            $this -> conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this -> username, $this ->password);
			$this -> conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this -> conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
	public function getData($tableName){
		    $q = "SELECT * FROM $tableName;";
    		$stmt = $this -> conn->prepare($q);
    		$stmt->execute();
    		$data = $stmt->fetchAll();
			return $data;
	}
	
	public function getDataId($tableName,$id) {
		$q = "SELECT * FROM $tableName WHERE id=$id;";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();
    	$data = $stmt->fetch();
		return $data;	
	}
	//Todo - After insert return data
	public function insertData($tableName, $data){
		    $q = "INSERT INTO $tableName (name, phone, email, image) values ( \"{$data['name']}\", \"{$data['phone']}\", \"{$data['email']}\", \"{$data['image']}\");";
    		$stmt = $this -> conn->prepare($q);
    		$stmt->execute();
			$lastId = $this->conn->lastInsertId();
			$data['id'] = $lastId;
			return $data;
	}
	public function insertData2($tableName, $data){
			print_r ($data);
		    $q = "INSERT INTO $tableName (name, description, image) values (\"{$data['name']}\", \"{$data['description']}\", \"{$data['image']}\");";
    		$stmt = $this -> conn->prepare($q);
    		$stmt->execute();
			return $data;
	}
	
	public function insertStudentCourses($data) {
		print_r('inside insert courses');
		print_r($data);
		$insertData = [];
		foreach($data as $value) {
			 array_push($insertData,"(".$value['student_id'].",".$value['course_id'].")");
		}
		$str = implode(",", $insertData);
		// (),(),();
		$q = "INSERT INTO student_course (student_id, course_id) values " .$str .";";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();
	}
	
	
	  public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}


?>