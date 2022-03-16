<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");
$tc = $_POST['tc'];
$remote_address = $_SERVER['REMOTE_ADDR']; 
$ref = $_SERVER['HTTP_REFERER'];
$servername = "localhost";
$username = "freeylap_affiliate";
$password = "~RR}V%D^f($N";
$dbname = "freeylap_affiliate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO click_records (tc, remote_address, ref)
    VALUES ($tc, $remote_address, $ref)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

 // set response code - 201 created
        http_response_code(201);
  
        echo json_encode($_POST['tc']);
        
        
?>