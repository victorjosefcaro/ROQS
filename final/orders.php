<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
</head>
<body>
    <!-- Orders Table -->
    <div class="container mt-5">
        <h2 class="pb-3">Orders</h2>
        <div class="accordion" id="ordersAccordion">
            <?php
            // Include your database connection file
            include 'db_connection.php';

            if(isset($_POST['order_served'])){
                $order_id = $_POST['order_id'];
                $update_query = "UPDATE orders SET order_status = 'Served' WHERE order_id = $order_id AND order_status = 'Pending'";
                $conn->query($update_query);
            }

            // Query to fetch data from the database
            $sql = "SELECT o.order_id, c.customer_name, d.item_id, d.item_quantity, d.item_requests, i.item_name, o.order_status
                    FROM orders AS o
                    INNER JOIN customers AS c ON o.customer_id = c.customer_id
                    INNER JOIN order_details AS d ON o.order_id = d.order_id
                    INNER JOIN items AS i ON d.item_id = i.item_id
                    WHERE o.order_status = 'Pending'";

            $result = $conn->query($sql);

            $current_order_id = null;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Check if the order ID has changed
                    if ($current_order_id !== $row['order_id']) {
                        // If it has changed, close the previous accordion body (if not first iteration)
                        if ($current_order_id !== null) {
                            ?>
                            </tbody>
                            </table>
                            </div>
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $current_order_id; ?>">
                                <button type="submit" name="order_served" class="btn btn-primary m-3">Mark as Served</button>
                            </form>
                            </div>
                            </div>
                            <?php
                        }

                        // Start a new accordion item for the new order
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['order_id']; ?>">
                                    <?php echo $row['customer_name']; ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $row['order_id']; ?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Requests</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php
                        // Update the current order ID
                        $current_order_id = $row['order_id'];
                    }
                    ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['item_quantity']; ?></td>
                        <td><?php echo $row['item_requests']; ?></td>
                    </tr>
                    <?php
                }
                // Close the last accordion body
                ?>
                </tbody>
                </table>
                </div>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $current_order_id; ?>">
                    <button type="submit" name="order_served" class="btn btn-primary m-3">Mark as Served</button>
                </form>
                </div>
                </div>
                </div>
                <?php
            } else {
                echo "No pending orders";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
</body>
</html>