<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roqsmain";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you pass reservation ID as a parameter named 'reservation_id'
$reservationId = $_GET['reservation_id'];

// Delete the served customer from the 'reservations' table
$sql = "DELETE FROM reservations WHERE reservation_id = $reservationId";
$result = $conn->query($sql);

// Return a response (e.g., success or error)
if ($result) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

// Close the database connection
$conn->close();
?>
