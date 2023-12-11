<?php
// delete_item.php

require_once "db_connection.php";

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Delete the item from the database
    $sql = "DELETE FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        header("Location: items.php");
        exit();
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid item ID";
}
?>