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
        <!-- Items -->
        <?php
            // Include the database connection file
            include 'db_connection.php';

            // Fetch data from the database
            $sql = "SELECT d.item_id, d.item_quantity, d.item_requests, i.item_name, i.item_price, (d.item_quantity * i.item_price) AS total_price
            FROM order_details d
            INNER JOIN items i
            ON d.item_id = i.item_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="card m-2 shadow-sm">
                            <div class="card-body">
                                <div class="row pb-1">
                                    <div class="col-8">
                                        <h5>' . $row["item_name"] . '</h5>
                                    </div>
                                    <div class="col-4">
                                        <div class="container d-flex ps-4">
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
                }
            } else {
                echo "0 results";
            }
        ?>
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
                                $sql = "SELECT COUNT(order_detail_id) AS row_count FROM order_details";
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
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
        <script src="cart.js"></script>
    </body>
</html>