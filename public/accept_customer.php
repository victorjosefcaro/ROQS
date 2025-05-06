<?php
// Include the database connection file
include 'db_connection.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer's party size
    $sql_select_customer = "SELECT customer_size FROM queue WHERE customer_id = ?";
    $stmt_select_customer = $conn->prepare($sql_select_customer);
    $stmt_select_customer->bind_param("i", $customer_id);
    $stmt_select_customer->execute();
    $stmt_select_customer->bind_result($customer_size);
    $stmt_select_customer->fetch();
    $stmt_select_customer->close();

    // Find an available table that fits the party size
    $sql_find_table = "SELECT table_id, table_size FROM tables WHERE table_status = 'available' AND table_size >= ? LIMIT 1";
    $stmt_find_table = $conn->prepare($sql_find_table);
    $stmt_find_table->bind_param("i", $customer_size);
    $stmt_find_table->execute();
    $stmt_find_table->bind_result($table_id, $table_size);

    if ($stmt_find_table->fetch()) {
        // Update table status to 'occupied'
        $stmt_find_table->close(); // Close the previous statement
        $sql_update_table = "UPDATE tables SET table_status = 'Occupied' WHERE table_id = ?";
        $stmt_update_table = $conn->prepare($sql_update_table);
        $stmt_update_table->bind_param("i", $table_id);
        $stmt_update_table->execute();
        $stmt_update_table->close();

        // Update customer's status to 'True' in the queue
        $sql_update_customer = "UPDATE queue SET customer_status = 'True' WHERE customer_id = ?";
        $stmt_update_customer = $conn->prepare($sql_update_customer);
        $stmt_update_customer->bind_param("i", $customer_id);
        $stmt_update_customer->execute();
        $stmt_update_customer->close();

        // Move customer data to the customers table
        $sql_move_customer = "INSERT INTO customers (customer_id, customer_name, customer_size) SELECT customer_id, customer_name, customer_size FROM queue WHERE customer_id = ?";
        $stmt_move_customer = $conn->prepare($sql_move_customer);
        $stmt_move_customer->bind_param("i", $customer_id);
        $stmt_move_customer->execute();
        $stmt_move_customer->close();
    }
}
// Redirect back to the queue table after update and transfer
header("Location: queue.php"); // Replace with the actual file name
exit();

?>