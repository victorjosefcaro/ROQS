<?php
// update_item.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $category_id = $_POST['category_id'];
    $item_description = $_POST['item_description'];
    $item_price = $_POST['item_price'];

    // File upload handling
    $item_image = null;
    if ($_FILES['item_image']['size'] > 0) {
        $item_image = file_get_contents($_FILES['item_image']['tmp_name']);
    }

    // Update the item details in the database including the item_image
    $sql = "UPDATE items SET item_name = ?, category_id = ?, item_description = ?, item_price = ?, item_image = ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $item_name, $category_id, $item_description, $item_price, $item_image, $item_id);

    if ($stmt->execute()) {
        header("Location: items.php");
        exit();
    } else {
        echo "Error updating item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}
?>
