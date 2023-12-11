<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if customer_id is provided in the POST request
    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];

        // Get the current date and time
        $order_date = date("Y-m-d H:i:s");

        // Insert the order date and customer_id into the orders table
        $insert_order_query = "INSERT INTO orders (order_date, customer_id) VALUES ('$order_date', '$customer_id')";
        
        if ($conn->query($insert_order_query) === TRUE) {
            // Get the last inserted order ID
            $order_id = $conn->insert_id;

            // Move cart items to order_details
            $insert_order_details_query = "INSERT INTO order_details (order_id, item_id, item_quantity, item_requests)
                SELECT $order_id, item_id, item_quantity, item_requests FROM cart";
            
            if ($conn->query($insert_order_details_query) === TRUE) {
                // Clear the cart for this customer
                $clear_cart_query = "DELETE FROM cart";
                $conn->query($clear_cart_query);

                echo "Order placed successfully!";
            } else {
                echo "Error transferring cart items: " . $conn->error;
            }
        } else {
            echo "Error placing order: " . $conn->error;
        }
    } else {
        echo "Customer ID not provided!";
    }
} else {
    echo "Invalid request!";
}
?>