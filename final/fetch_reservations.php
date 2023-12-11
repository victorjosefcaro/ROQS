<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roqs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch queue from the database
$sql = "SELECT customer_id, customer_name, customer_size FROM queue"; // Update column names
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $queue = array();
    while ($row = $result->fetch_assoc()) {
        $queue[] = $row;
    }
    echo json_encode($queue);
} else {
    // No queue found
    echo json_encode(array());
}

// Close the database connection
$conn->close();
?>
