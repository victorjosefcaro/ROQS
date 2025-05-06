<?php
require_once "db_connection.php";

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch the category details based on $category_id from the database
    // Use prepared statements to prevent SQL injection

    $sql = "SELECT * FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the form to edit category details
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Category</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Category</h2>
                <form method="POST" action="update_category.php">
                    <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $row['category_name']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a class="btn btn-secondary" href="categories.php" role="button">Back</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Category not found";
    }
    $stmt->close();
} else {
    echo "Invalid category ID";
}
?>