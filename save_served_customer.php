<?php
// Assuming you are using MySQLi for database connection

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

// Get data from the POST request
$name = $_POST['name'];
$partySize = $_POST['party_size'];

// Escape and validate user inputs for security
$name = $conn->real_escape_string(validateInput($name));
$partySize = $conn->real_escape_string(validateInput($partySize));

// Insert data into the 'customers' table
$sql = "INSERT INTO customers (customer_name, party_size) VALUES ('$name', '$partySize')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error saving customer to database']);
}

// Close the database connection
$conn->close();

function validateInput($input) {
    // Implement input validation/sanitization logic as needed
    // For simplicity, you may use functions like filter_var or implement your own logic
    return $input;
}
?>
