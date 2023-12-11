<?php
// Include the database connection file
include 'db_connection.php';

session_start();

if (isset($_SESSION['customer_name'])) {
    $customer_name = $_SESSION['customer_name'];
} else {
    echo "Session not found";
    exit();
}

// Prepare and execute a query to check the customer_status for the specific user
$stmt = $conn->prepare("SELECT customer_status FROM queue WHERE customer_name = ?");
$stmt->bind_param("s", $customer_name);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Fetch the result
    $stmt->bind_result($customer_status);
    $stmt->fetch();

    // Return the customer_status
    echo $customer_status;
} else {
    echo "Not found";
}

$stmt->close();
$conn->close();
?>