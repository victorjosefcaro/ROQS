<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['user_password']) && isset($_POST['user_type'])) {
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_type = $_POST['user_type'];

    // Hash the password
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Insert the new user into the database with hashed password
    $sql = "INSERT INTO users (username, user_password, user_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $user_type); // Binding parameters

    if ($stmt->execute()) {
        // Redirect back to accounts.php after successful addition
        header("Location: accounts.php");
        exit();
    } else {
        echo "Error adding account: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Account</h2>
    <form method="POST" action="add_user.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="user_password">Password:</label>
            <input type="password" class="form-control" id="user_password" name="user_password">
        </div>
        <div class="form-group">
            <label for="user_type">User Type:</label>
            <select class="form-control" id="user_type" name="user_type">
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
        <a class="btn btn-secondary" href="accounts.php" role="button">Back</a>
    </form>
</div>

</body>
</html>