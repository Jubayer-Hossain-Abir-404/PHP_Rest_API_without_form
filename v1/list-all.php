<?php 

	ini_set("display_errors", 1);
	// include headers
	header("Access-Control-Allow-Origin: *"); 
	// it allow all origins like localhost, any domain or subdomain
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
		$data = $student->get_all_data();

		if($data->num_rows > 0){
			// we have some data inside table
			$students["records"] = array();
			while($row = $data->fetch_assoc()){

				//print_r($row);
				array_push($students["records"],array(
					"id" => $row['id'],
					"name" => $row['name'],
					"email" => $row['email'],
					"mobile" => $row['mobile'],
					"status" => $row['status'],
					"created_at" => date("Y-m-d",strtotime($row['created_at']))
				));
			}

			http_response_code(200);
			echo json_encode(array(
				"status" => 1,
				"data" => $students["records"]
			));

		}
	}else{
		http_response_code(503); //service unavailable
		echo json_encode(array(
			"status" => 0,
			"message" => "Access Denied"
		));
	}	

?>