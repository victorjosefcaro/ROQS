<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id']) && isset($_POST['item_stock'])) {
    $item_id = $_POST['item_id'];
    $item_stock = $_POST['item_stock'];

    // Insert the new item into the database
    $sql = "INSERT INTO inventory (item_id, item_stock) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item_id, $item_stock); // "ii" denotes two integer parameters

    if ($stmt->execute()) {
        // Redirect back to inventory.php after successful addition
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error adding inventory: " . $conn->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Inventory</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="item_id">Item ID:</label>
            <input type="text" class="form-control" id="item_id" name="item_id">
        </div>
        <div class="form-group">
            <label for="item_stock">Item Stock:</label>
            <input type="text" class="form-control" id="item_stock" name="item_stock">
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
        <a class="btn btn-secondary" href="inventory.php" role="button">Back</a>
    </form>
</div>

</body>
</html>