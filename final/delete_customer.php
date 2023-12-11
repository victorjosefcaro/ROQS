<?php
// Include the database connection file
include 'db_connection.php';

// Check if the customer ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $customer_id = $_GET['id'];

    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM queue WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();

    // Close statement
    $stmt->close();
}

// Redirect back to the queue table after deletion
header("Location: queue.php"); // Replace with the actual file name
exit();
?>