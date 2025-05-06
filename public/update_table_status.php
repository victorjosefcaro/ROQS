<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tableId'])) {
    $tableId = $_POST['tableId'];

    // Update table status to 'Available'
    $sql_update_table = "UPDATE tables SET table_status = 'Available' WHERE table_id = ?";
    $stmt_update_table = $conn->prepare($sql_update_table);
    $stmt_update_table->bind_param("i", $tableId);
    
    if ($stmt_update_table->execute()) {
        echo "Table status updated successfully";
    } else {
        echo "Error updating table status: " . $conn->error;
    }

    $stmt_update_table->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>