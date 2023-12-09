<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item ID sent from AJAX
    $item_id = $_POST['item_id'];

    // Prepare and execute the SQL query to delete the item
    $sql = "DELETE FROM order_details WHERE item_id = '$item_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully!";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}

$conn->close();
?>