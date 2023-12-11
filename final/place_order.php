<?php
include("db_connection.php");

// Retrieve data sent from AJAX
$item_id = $_POST['item_id'];
$item_quantity = $_POST['item_quantity'];
$item_requests = $_POST['item_requests'];

// Prepare and execute the SQL query
$sql = "INSERT INTO cart (item_id, item_quantity, item_requests)
VALUES ('$item_id', '$item_quantity', '$item_requests')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>