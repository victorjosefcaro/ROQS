<?php
// update_inventory.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inventory_id'])) {
    $inventory_id = $_POST['inventory_id'];
    $item_stock = $_POST['item_stock'];

    // Update inventory item based on inventory_id
    $sql = "UPDATE inventory SET item_stock = ? WHERE inventory_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item_stock, $inventory_id);

    if ($stmt->execute()) {
        // Redirect to inventory.php after successful update
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error updating inventory item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}
?>