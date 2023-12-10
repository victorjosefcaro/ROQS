<?php
include("db_connection.php");

// Retrieve data sent from AJAX
$customer_id = $_POST['customer_id'];
$variation_id = $_POST['variation_id'];
$quantity = $_POST['quantity'];
$requests = $_POST['requests'];

// Prepare and execute the SQL query
$sql = "INSERT INTO cart (customer_id, variation_id, quantity, requests)
VALUES ('$customer_id', '$variation_id', '$quantity', '$requests')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>