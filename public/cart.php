<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    </head>
    <body>
        <!-- Header -->
        <h1 class="text-center py-3">Cart</h1>
        <?php
            session_start();
            if (isset($_SESSION['customer_name'])) {
                $customer_name = $_SESSION['customer_name'];
                
                // Include the database connection file
                include 'db_connection.php';

                // Prepare and execute SELECT statement to retrieve customer_id based on customer_name
                $sql_select_id = "SELECT customer_id FROM customers WHERE customer_name = ?";
                $stmt_select_id = $conn->prepare($sql_select_id);
                $stmt_select_id->bind_param("s", $customer_name);
                $stmt_select_id->execute();
                $stmt_select_id->bind_result($customer_id);

                // Fetch customer_id
                if ($stmt_select_id->fetch()) {
                    // Store customer_id in a session variable for later use
                    $_SESSION['customer_id'] = $customer_id;
                    echo "<p class='text-center fs-2'>Hello, $customer_name</p>";
                } else {
                    echo "<p class='text-center'>Hello, $customer_name (ID not found)</p>";
                }

                // Close the statement
                $stmt_select_id->close();
                $conn->close();
            }
        ?>
        <!-- Items -->
        <?php
            // Include the database connection file
            include 'db_connection.php';

            // Fetch data from the database
            $sql = "SELECT c.item_id, c.item_quantity, c.item_requests, i.item_name, i.item_price, (c.item_quantity * i.item_price) AS total_price
            FROM cart c
            INNER JOIN items i
            ON c.item_id = i.item_id";
            $result = $conn->query($sql);

            $totalPriceOfOrders = 0; // Initialize total price variable

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="card m-2 shadow-sm" style="max-height: 150px;">
                            <div class="card-body">
                                <div class="row pb-1">
                                    <div class="col-8">
                                        <h5>' . $row["item_name"] . '</h5>
                                    </div>
                                    <div class="col-4">
                                        <div class="container d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-sm btn-secondary order-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-item-id="'. $row['item_id'] . '"
                                                data-item-name="' . $row["item_name"] . '"
                                                data-item-price="' . $row["item_price"] . '"
                                                data-item-quantity="' . $row["item_quantity"] . '"
                                                data-item-requests="' . $row["item_requests"] . '"
                                            ><i class="fa-solid fa-edit fa-xs"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger ms-1" id="delete"
                                                data-item-id="'. $row['item_id'] . '"
                                            >
                                                <i class="fa-solid fa-trash fa-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="fs-4">Amount: ' . $row["item_quantity"] . '</p>
                                <p class="fs-4">₱ ' . $row["total_price"] . '</p>
                            </div>
                        </div>';
                    // Calculate total price for each item and add to the total price
                    $totalPriceOfOrders += $row["total_price"];
                }
            } else {
                echo '
                    <p class="fs-2 pt-5 text-center">Cart is empty</p>
                ';
            }
            // Display the total price of all orders
            echo '
            <hr class="mx-3">
            <div>
                <h4 class="mx-3">Total: ₱ ' . number_format($totalPriceOfOrders, 2) . '</h4>
            </div>';
        ?>
        <button type="button" class="btn btn-primary mx-3" id="placeOrderBtn">Place Orders</button>
        <hr class="mx-3 mb-5">
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Order Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalItemId" class="visually-hidden"></p>
                        <h1 class="modal-title" id="modalItemName"></h1>
                        <div class="input-group px-4 py-2 w-50 mx-auto">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-number" id="decrement">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </span>
                            <input type="text" class="form-control input-number" min="1" id="amount">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number" id="increment">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </span>
                        </div>
                        <div class="form-floating my-3">
                            <textarea class="form-control" id="itemRequests" style="height: 100px"></textarea>
                            <label>Additional requests</label>
                        </div>
                        <h1 id="modalItemPrice"></h1>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="editOrder()">Edit Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Nav Bar -->
        <nav class="navbar bg-primary fixed-bottom p-2">
            <div class="container">
                <a href="main.php" class="btn btn-primary" role="button">
                    <i class="fa-solid fa-house mx-3" style="color: #ffffff;"></i>
                </a>
                <a href="cart.php" class="btn btn-primary" role="button">
                    <i class="fa-solid fa-cart-shopping mx-3" style="color: #ffffff;"></i>
                    <span class="position-relative">
                        <span class="badge bg-danger rounded position-absolute top-0 start-100 translate-middle">
                            <?php
                                // Include the database connection file
                                include 'db_connection.php';

                                // Query to count rows
                                $sql = "SELECT COUNT(order_detail_id) AS row_count FROM cart";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $count = $row["row_count"];
                                    // Display the badge with the dynamic count
                                    echo $count;
                                } else {
                                    echo "0 rows";
                                }
                            ?>
                        </span>
                    </span>
                </a>
                <a href="status.php" class="btn btn-primary" role="button">
                    <i class="fa-solid fa-clock mx-3" style="color: #ffffff;"></i>
                </a>
            </div>
        </nav>
        <script>
            // Get the customer ID from PHP and store it in a JavaScript variable
            var customerId = <?php echo isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 'null'; ?>;
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
        <script src="cart.js"></script>
    </body>
</html>