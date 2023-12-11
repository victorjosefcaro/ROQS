<?php
require_once "db_connection.php";

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    $sql = "DELETE FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        header("Location: categories.php");
        exit();
    } else {
        echo "Error deleting category: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid category ID";
}
?>