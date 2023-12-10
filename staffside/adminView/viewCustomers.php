<?php

// Include the configuration file
@include 'config.php';

// Function to delete a user by user_id
function deleteUser($userId) {
    global $conn;

    $userId = mysqli_real_escape_string($conn, $userId);

    $sql = "DELETE FROM users WHERE user_id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('User deleted successfully');
        window.location.href = '../index.php';
      </script>";
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

        // // Redirect to another page after deleting the user
        // header("Location: ../index.php");
        exit();
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
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: -20px;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* delete */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* new account */
        }

        button {
            background-color: #008CBA; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
        }

        button:hover {
            background-color: #005A8C;
        }
    </style>
    </style>
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
        <!-- Button to redirect to another page -->
        <a href="register_form.php"><button type="button">Create Account</button></a>
    </form>

</body>

</html>

<?php

// Close the database connection
$conn->close();

?>
