<?php
// delete_inventory.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $inventory_id = $_GET['id'];

    // Delete inventory item based on inventory_id
    $sql = "DELETE FROM inventory WHERE inventory_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inventory_id);

    if ($stmt->execute()) {
        // Redirect to inventory.php after successful deletion
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error deleting inventory item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}
?>