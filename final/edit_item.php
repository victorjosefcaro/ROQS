<?php
// edit_item.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Fetch the item details based on $item_id from the database
    // Use prepared statements to prevent SQL injection

    $sql = "SELECT item_id, item_name, category_id, item_description, item_price, item_image FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Item</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Item</h2>
                <form method="POST" action="update_item.php">
                    <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                    <div class="form-group">
                        <label for="item_name">Item Name:</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $row['item_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category ID:</label>
                        <input type="text" class="form-control" id="category_id" name="category_id" value="<?php echo $row['category_id']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="item_description">Item Description:</label>
                        <textarea class="form-control" id="item_description" name="item_description"><?php echo $row['item_description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="item_price">Item Price:</label>
                        <input type="text" class="form-control" id="item_price" name="item_price" value="<?php echo $row['item_price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="item_image">Item Image:</label>
                        <input type="file" class="form-control-file" id="item_image" name="item_image">
                    </div>
                    <!-- Other form fields for item details -->
                    <!-- Adjust form fields as per your item details -->
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a class="btn btn-secondary" href="items.php" role="button">Back</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Item not found";
    }
    $stmt->close();
} else {
    echo "Invalid request";
}
?>