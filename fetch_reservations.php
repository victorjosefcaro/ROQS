<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_process";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reservations from the database
$sql = "SELECT reservation_id, name, party_size FROM reservations"; // Update column names
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $reservations = array();
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    echo json_encode($reservations);
} else {
    // No reservations found
    echo json_encode(array());
}

// Close the database connection
$conn->close();
?>
