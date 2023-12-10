<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item ID sent from AJAX
    $variation_id_id = $_POST['variation_id'];

    // Prepare and execute the SQL query to delete the item
    $sql = "DELETE FROM cart WHERE variation_id = '$variation_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully!";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}

$conn->close();
?>