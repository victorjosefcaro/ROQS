<?php
// Assuming you are using MySQLi for database connection

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

// Get data from the POST request
$customerId = $_POST['customer_id'];
$name = $_POST['name'];
$partySize = $_POST['party_size'];

// Escape user inputs for security
$customerId = $conn->real_escape_string($customerId);
$name = $conn->real_escape_string($name);
$partySize = $conn->real_escape_string($partySize);

// Insert data into the 'queued_customer' table
$sql = "INSERT INTO customers (customer_id, name, party_size) VALUES ('$customerId', '$name', '$partySize')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

// Close the database connection
$conn->close();
?>
