<?php
include("db_connection.php");

// Retrieve data sent from AJAX
$item_id = $_POST['item_id'];
$item_quantity = $_POST['item_quantity'];
$item_requests = $_POST['item_requests'];

// Prepare and execute the SQL query
$sql = "UPDATE cart
SET item_quantity = '$item_quantity', item_requests = '$item_requests'
WHERE item_id = '$item_id'";

if ($conn->query($sql) === TRUE) {
    echo "Order edited successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>