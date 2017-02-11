<?php
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
	
	public function checkLogInCredentials($tableName,$email, $pass) {
		$q = "SELECT * FROM $tableName WHERE email='$email' AND pass='$pass';";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();
    	$data = $stmt->fetch();
		return $data;	
	}
	
	public function getAllStudentsInCourse($courseId){
		$q = "SELECT student_course.student_id, students.name FROM `student_course` 
				INNER JOIN students on students.id = student_course.student_id
				WHERE student_course.course_id =$courseId";
		$stmt = $this -> conn->prepare($q);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;	
	}
	
	public function getAllStudentCourses($studentId){
		$q = "SELECT student_course.course_id, courses1.name FROM `student_course` 
				INNER JOIN courses1 on courses1.id = student_course.course_id
				WHERE student_course.student_id =$studentId";
		$stmt = $this -> conn->prepare($q);
		$stmt->execute();
		$data = $stmt->fetchAll();
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
	
	//inserts admin to db
	public function insertAdminToDb($tableName, $data){
		$name = $data['name']; $role = $data['role']; $phone = $data['phone']; $email = $data['email'];
		$pass = $data['pass']; $image = $data['image'];
/*		$q = "INSERT INTO $tableName (name, role, phone, email, pass, image) values "(\"$name\", \"$role\", \"$phone\",\"$email\", \"$pass\", \"$image\");";*/
    	$values = <<<values
		("$name", "$role", "$phone","$email","$pass","$image")
values;
		$q = "INSERT INTO $tableName (name, role, phone, email, pass, image) values".$values;
		print_r('the db print');
		print_r($q);
    		$stmt = $this -> conn->prepare($q);
    		$stmt->execute();
			return $data;
	}
	
	
	public function deleteStudent($tableName, $id) {
		$q = "DELETE FROM $tableName WHERE id=$id;";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();	
	}
	
	public function deleteCourse($tableName, $id) {
		$q = "DELETE FROM $tableName WHERE id=$id;";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();	
	}
	
	public function deleteAdmin($tableName, $id) {
		$q = "DELETE FROM $tableName WHERE id=$id;";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();	
	}
	
	public function updateStudent($tableName, $id, $data) {
		$q = "UPDATE $tableName SET name='".$data['name']."', phone='".$data['phone']."', email='".$data['email']."',	image='".$data['image']."' WHERE id='".$id."';";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();	
		
	}
    
    public function updateCourse($tableName, $id, $data) {
        fwrite($myfile, '$data= ');
        fwrite($myfile, print_r($data, TRUE));
        fclose($myfile);
		$q = "UPDATE $tableName SET name='".$data['name']."', description='".$data['description']."', image='".$data['image']."' WHERE id='".$id."';";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();	
		
	}
	
   public function updateAdmin ($tableName, $id, $data){
       $q = "UPDATE $tableName SET name='".$data['name']."', role='".$data['role']."', phone='".$data['phone']."',	email='".$data['email']."',pass='".$data['pass']."',image='".$data['image']."' WHERE id='".$id."';";
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