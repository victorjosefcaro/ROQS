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
        <?php
            // Start the session
            session_start();

            // Check if the username and user_type are set in the session
            if (isset($_SESSION['username']) && isset($_SESSION['user_type'])) {
                $username = $_SESSION['username'];
                $user_type = $_SESSION['user_type'];
                echo '<div class="container mt-5">
                    <h1>
                    Hello, ' . htmlspecialchars($username) . '
                    </h1>
                    </div>';
            }
        ?>
        <?php
            // Include the database connection file
            include 'db_connection.php';

            // Function to get row count from a table
            function getRowCount($conn, $tableName) {
                $sql = "SELECT COUNT(*) AS count FROM $tableName";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['count'];
                } else {
                    return 0;
                }
            }

            // Getting row counts for different tables
            $totalCategories = getRowCount($conn, 'categories');
            $totalInventory = getRowCount($conn, 'inventory');
            $totalItems = getRowCount($conn, 'items');
            $totalAccounts = getRowCount($conn, 'users');

            // Close the database connection
            $conn->close();
        ?>
        <div class="container mt-5">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories: <?php echo $totalCategories; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Items in Inventory: <?php echo $totalInventory; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Products: <?php echo $totalItems; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Accounts: <?php echo $totalAccounts; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
    </body>
</html>