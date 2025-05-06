<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from the form
    $tableSize = $_POST['table_size']; // Assuming you have a form field for table size

    // Prepare and execute SQL statement to insert data into the tables table
    $stmt = $conn->prepare("INSERT INTO tables (table_size, table_status) VALUES (?, 'Available')");
    $stmt->bind_param("i", $tableSize); // Assuming table_size is an integer type
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to the main page or perform any other actions
        header("Location: queue.php"); // Replace 'index.php' with your main page
        exit();
    } else {
        // Handle insertion failure
        echo "Failed to add a new table.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>