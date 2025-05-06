<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="staff_index.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inventory.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="items.php">Items</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="accounts.php">Accounts</a>
                        </li>
                    </ul>
                    <div class="navbar-text me-2">
                        <a class="nav-link" href="login.php">Logout</a>
                    </div>
                </div>       
            </div>
        </nav>
        <!-- Items Table -->
        <div class="container mt-5">
            <h2 class="pb-3">Items</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Category ID</th>
                        <th>Item Description</th>
                        <th>Item Price</th>
                        <th>Item Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // Include the database connection file
                include 'db_connection.php';

                // Fetching data from categories table
                $sql = "SELECT item_id, item_name, category_id, item_description, item_price, item_image FROM items";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["item_id"] . "</td>";
                        echo "<td>" . $row["item_name"] . "</td>";
                        echo "<td>" . $row["category_id"] . "</td>";
                        echo "<td>" . $row["item_description"] . "</td>";
                        echo "<td>" . $row["item_price"] . "</td>";
                        echo "<td>";
                        if ($row["item_image"] != null) {
                            $imageData = base64_encode($row["item_image"]);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Item Image" style="max-width: 100px; max-height: 100px;">';
                        } else {
                            echo "No image available";
                        }
                        echo "</td>";
                        echo "<td>
                                <a href='edit_item.php?id=" . $row["item_id"] . "' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='delete_item.php?id=" . $row["item_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No items found</td></tr>";
                }

                $conn->close();
                ?>

                </tbody>
            </table>
            <div class="mb-3">
                <a href="add_item.php" class="btn btn-success">Add Item</a>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
    </body>
</html>