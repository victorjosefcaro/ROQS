<?php
include("db_connection.php");

// Retrieve data sent from AJAX
$variation_id = $_POST['variation_id'];
$quantity = $_POST['quantity'];
$requests = $_POST['requests'];

// Prepare and execute the SQL query
$sql = "UPDATE cart
SET quantity = '$quantity', requests = '$requests'
WHERE variation = '$variation_id'";

if ($conn->query($sql) === TRUE) {
    echo "Order edited successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>