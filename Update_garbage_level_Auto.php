<?php
// Database configuration
$servername = "root";
$username = "localhost";
$password = "Sai@04c2";
$dbname = "Garbage_level";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive JSON data from HTTP POST request
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['garbage_level'])) {
    $garbageLevel = $data['garbage_level'];
    
    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO garbage_data (timestamp, garbage_level) VALUES (NOW(), $garbageLevel)";
    if ($conn->query($sql) === TRUE) {
        http_response_code(200); // Return a success response
    } else {
        http_response_code(500); // Return an error response
    }
} else {
    http_response_code(400); // Return an error response
}

$conn->close();
?>
