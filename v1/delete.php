<?php 
	header("Access-Control-Allow-Origin: *");
	// passing json data or data type while calling this api
	header("Access-Control-Allow-Methods: GET");
	// method type

	// include database.php
	include_once("../config/database.php");
	// include student.php
	include_once("../classes/student.php");

	// create object for database
	$db = new Database();

	$connection = $db->connect();


	// create object for student
	$student = new Student($connection);

	if($_SERVER['REQUEST_METHOD'] === "GET"){
		$student_id = isset($_GET['id']) ? $_GET['id'] : "";

		if(!empty($student_id)){
			$student->id = $student_id;
			if($student->delete_student()){
				http_response_code(200); // OK
				echo json_encode(array(
					"status" => 1,
					"message" => "Student deleted successfully"
				));
			}else{
				http_response_code(500); // server error
				echo json_encode(array(
					"status" => 0,
					"message" => "Failed to delete student"
				));
			}
		}else{
			http_response_code(404);  // data not found
			echo json_encode(array(
				"status" => 0,
				"message" => "All data needed"
			));
		}
	}else{
		http_response_code(503); // service unavailable
		echo json_encode(array(
			"status" => 0,
			"message" => "Access Denied"
		));
	}


?>