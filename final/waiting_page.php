<?php
session_start();

if (isset($_SESSION['customer_name'])) {
    $customer_name = $_SESSION['customer_name'];
} else {
    $customer_name = "Guest";
}

// Include the database connection
include 'db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function checkStatus() {
                // AJAX call to check the customer_status
                $.ajax({
                    url: 'check_status.php',
                    type: 'GET',
                    success: function (response) {
                        if (response === 'True') {
                            window.location.href = 'main.php';
                        }
                    }
                });
            }

            // Check the status every 5 seconds
            setInterval(checkStatus, 5000);
        });
    </script>
</head>

<body>
    <!-- Your HTML content -->

    <div class="vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="text-center">Hello, <?php echo $customer_name; ?></h1>
            <p class="text-center fs-1">Please wait for the staff to accept your request</p>
        </div>
    </div>

    <!-- Bootstrap, Font Awesome scripts, etc. -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c4e0b1b67d.js" crossorigin="anonymous"></script>
</body>

</html>
