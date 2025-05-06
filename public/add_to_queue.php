<?php
// Include the database connection file
include 'db_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['customer_name']) && isset($_POST['customer_size'])) {
        // Assuming form inputs
        $customer_name = $_POST['customer_name'];
        $customer_size = $_POST['customer_size'];

        // Insert the customer into the queue table with name and size
        $stmt = $conn->prepare("INSERT INTO queue (customer_name, customer_size) VALUES (?, ?)");
        $stmt->bind_param("si", $customer_name, $customer_size);
        $stmt->execute();
        $stmt->close();

        // Set the customer_name in the session
        $_SESSION['customer_name'] = $customer_name;

        // Optionally, set customer_size in the session if needed
        $_SESSION['customer_size'] = $customer_size;

        // Redirect to the waiting page
        header("Location: waiting_page.php");
        exit();
    }
}
?>