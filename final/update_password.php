<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetching the current hashed password from the database for the user
    $sql = "SELECT user_password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['user_password'];

        // Verify the old password provided by the user
        if (password_verify($old_password, $hashed_password)) {
            // Validate the new password and confirm password match
            if ($new_password === $confirm_password) {
                // Hash the new password before updating in the database
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $update_sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $hashed_new_password, $user_id);

                if ($update_stmt->execute()) {
                    // Password updated successfully
                    header("Location: accounts.php"); // Redirect to a success page
                    exit();
                } else {
                    echo "Error updating password: " . $update_stmt->error;
                }
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Incorrect old password.";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
    $update_stmt->close();
} else {
    echo "Invalid request";
}

$conn->close();
?>