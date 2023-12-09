<?php

// Include the configuration file
@include 'config.php';

// Function to delete a user by user_id
function deleteUser($userId) {
    global $conn;

    $userId = mysqli_real_escape_string($conn, $userId);

    $sql = "DELETE FROM users WHERE user_id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User deleted successfully');</script>";
        // Redirect to a success page if needed
        // header("Location: ../index.php");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the userId is set in the POST data
    if (isset($_POST["userId"])) {
        $userId = $_POST["userId"];
        deleteUser($userId);
    } else {
        // echo "Invalid user ID";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>

    <h2>Delete User</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="userId">Select User ID to Delete:</label>
        <select name="userId" id="userId">
            <?php
            // Retrieve user IDs and names from the users table
            $result = $conn->query("SELECT user_id, name FROM users");
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"{$row['user_id']}\">{$row['user_id']} - {$row['name']}</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Delete User">
    </form>

</body>
</html>

<?php

// Close the database connection
$conn->close();

?>
