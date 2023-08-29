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

// Query to retrieve garbage level data
$sql = "SELECT timestamp, garbage_level FROM garbage_data ORDER BY timestamp DESC LIMIT 10"; // Change the query to match your table structure and requirements
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entry = array(
            "timestamp" => $row["timestamp"],
            "garbage_level" => $row["garbage_level"]
        );
        array_push($data, $entry);
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
