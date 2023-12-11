<?php
session_start();
// Include the database connection file
require_once 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch the hashed password for the provided username
    $query = "SELECT user_password FROM users WHERE username='$username'";

    // Perform the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Check if any row matches the username
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['user_password'];

            // Verify the entered password with the hashed password
            if (password_verify($password, $hashed_password)) {
                // Password matches, redirect to staff_index.php
                $_SESSION['username'] = $username;
                header("Location: staff_index.php");
                exit();
            } else {
                // Login failed due to invalid password
                $error_message = "Invalid credentials";
                header("Location: login.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            // No user found with the provided username
            $error_message = "Invalid credentials";
            header("Location: login.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        // Query failed
        $error_message = "Error: " . mysqli_error($conn);
        header("Location: login.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // If the form was not submitted, redirect to the login page
    header("Location: login.php");
    exit();
}
?>