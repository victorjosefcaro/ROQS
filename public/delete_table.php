<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $tableId = $_GET['id'];

    // Prepare a DELETE statement
    $sql = "DELETE FROM tables WHERE table_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $tableId);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Table deleted successfully
            header("Location: queue.php"); // Redirect back to the previous page after deletion
            exit();
        } else {
            // Error while deleting the table
            echo "Error: " . $conn->error;
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>