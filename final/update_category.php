<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id']) && isset($_POST['category_name'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    $sql = "UPDATE categories SET category_name = ? WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category_name, $category_id);

    if ($stmt->execute()) {
        header("Location: categories.php");
        exit();
    } else {
        echo "Error updating category: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
