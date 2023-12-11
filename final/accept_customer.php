<?php
// Include the database connection file
include 'db_connection.php';

// Check if the customer ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $customer_id = $_GET['id'];

    // Prepare and execute the UPDATE statement to set customer_status to True
    $sql_update = "UPDATE queue SET customer_status = 'True' WHERE customer_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $customer_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Prepare and execute SELECT statement to fetch customer data
    $sql_select = "SELECT customer_name, customer_size FROM queue WHERE customer_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $customer_id);
    $stmt_select->execute();
    $stmt_select->bind_result($customer_name, $customer_size);

    // Fetch customer data
    if ($stmt_select->fetch()) {
        $stmt_select->close(); // Close the SELECT statement before proceeding

        // Prepare and execute INSERT statement to transfer data to customers table
        $sql_insert = "INSERT INTO customers (customer_id, customer_name, customer_size) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $customer_id, $customer_name, $customer_size);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
}

// Redirect back to the queue table after update and transfer
header("Location: queue.php"); // Replace with the actual file name
exit();
?>