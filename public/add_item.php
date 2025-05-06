<?php
// add_item.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_name'])) {
    $item_name = $_POST['item_name'];
    $category_id = $_POST['category_id'];
    $item_description = $_POST['item_description'];
    $item_price = $_POST['item_price'];

    // File upload handling
    $item_image = null;
    if ($_FILES['item_image']['size'] > 0) {
        $item_image = file_get_contents($_FILES['item_image']['tmp_name']);
    }

    // Insert new item into the database
    $sql = "INSERT INTO items (item_name, category_id, item_description, item_price, item_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $item_name, $category_id, $item_description, $item_price, $item_image);

    if ($stmt->execute()) {
        // Redirect to items.php (or any other desired page) after successful addition
        header("Location: items.php");
        exit();
    } else {
        echo "Error adding item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Item</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" class="form-control" id="item_name" name="item_name">
            </div>
            <div class="form-group">
                <label for="category_id">Category ID:</label>
                <input type="text" class="form-control" id="category_id" name="category_id">
            </div>
            <div class="form-group">
                <label for="item_description">Item Description:</label>
                <textarea class="form-control" id="item_description" name="item_description"></textarea>
            </div>
            <div class="form-group">
                <label for="item_price">Item Price:</label>
                <input type="text" class="form-control" id="item_price" name="item_price">
            </div>
            <div class="form-group">
                <label for="item_image">Item Image:</label>
                <input type="file" class="form-control-file" id="item_image" name="item_image">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
            <a class="btn btn-secondary" href="items.php" role="button">Back</a>
        </form>
    </div>
</body>
</html>