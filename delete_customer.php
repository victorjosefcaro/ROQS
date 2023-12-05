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

// Assuming you pass customer ID as a parameter named 'customer_id'
$customerId = $_GET['customer_id'];

// Delete the served customer
$sql = "DELETE FROM reservation WHERE id = $customerId";
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
