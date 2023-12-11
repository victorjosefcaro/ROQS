<?php
// edit_inventory.php

require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $inventory_id = $_GET['id'];

    // Fetch inventory details based on inventory_id and display in a form
    $sql = "SELECT inventory.inventory_id, inventory.item_id, items.item_name, inventory.item_stock 
            FROM inventory 
            INNER JOIN items ON inventory.item_id = items.item_id 
            WHERE inventory.inventory_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inventory_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Inventory</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Inventory</h2>
                <!-- Create a form to edit inventory details -->
                <!-- Include input fields for editing item stock -->
                <form method="POST" action="update_inventory.php">
                    <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                    <div class="form-group">
                        <label for="item_name">Item Name:</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $row['item_name']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="item_stock">Item Stock:</label>
                        <input type="number" class="form-control" id="item_stock" name="item_stock" value="<?php echo $row['item_stock']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a class="btn btn-secondary mt-3" href="inventory.php" role="button">Back</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Inventory item not found";
    }
    $stmt->close();
} else {
    echo "Invalid request";
}
?>