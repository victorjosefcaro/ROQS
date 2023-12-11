<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
        <link
            href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100&display=swap"
            rel="stylesheet"
        />
    </head>
    <body>
        <!-- Queue Table -->
        <div class="container mt-5">
            <h2 class="pb-3">Queue</h2>
            <div class="container m-3 d-flex">
                <?php
                include 'db_connection.php';

                $sql ="SELECT table_id, table_size, table_status FROM tables";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tableId = $row["table_id"];
                        $cardClass = ($row["table_status"] === 'Occupied') ? 'bg-danger' : '';
                        echo '
                            <div class="card mx-2 shadow-sm ' . $cardClass . '" style="width: 12rem;">
                                <a href="delete_table.php?id=' . $row["table_id"] . '" class="btn btn-danger btn-sm delete-table position-absolute top-0 end-0 mt-2 me-2">
                                    <i class="fa-solid fa-times"></i>
                                </a>
                                <div class="card-body text-center">
                                    <h4 class="card-title mb-4">Table ' . $row["table_id"] . '</h4>
                                    <p class="card-title">Status: ' . $row["table_status"] . '</p>
                                    <p class="card-title">Seats: ' . $row["table_size"] . '</p>
                                    <button type="button" class="btn btn-primary btn-sm make-available" data-table-id="' . $tableId . '">
                                        Make table available
                                    </button>
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
            <div class="container d-flex mb-3">
                <form action="add_table.php" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" style="max-width: 8rem;" placeholder="No. of seats" name="table_size">
                        <button type="submit" class="btn btn-success">Add Table</button>
                    </div>
                </form>
            </div>  
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Party Size</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // Include the database connection file
                include 'db_connection.php';

                // Fetching data from queue table
                $sql = "SELECT customer_id, customer_name, customer_size, customer_status FROM queue";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["customer_name"] . "</td>";
                        echo "<td>" . $row["customer_size"] . "</td>";
                        echo "<td>
                                <a href='accept_customer.php?id=" . $row["customer_id"] . "' class='btn btn-primary btn-sm'>Accept</a>
                                <a href='delete_customer.php?id=" . $row["customer_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No customers found</td></tr>";
                }

                $conn->close();
                ?>

                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            $('.make-available').click(function() {
                var tableId = $(this).data('table-id');

                // Send an asynchronous request to update the table status
                $.ajax({
                    url: 'update_table_status.php', // Replace with the actual PHP file to handle the update
                    type: 'POST',
                    data: { tableId: tableId },
                    success: function(response) {
                        // If the update was successful, reload the page or update UI as needed
                        location.reload(); // Reload the page after successful update
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if any
                        console.error(error);
                    }
                });
            });
        </script>
    </body>
</html>