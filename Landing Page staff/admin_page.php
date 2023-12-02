<?php
@include 'config.php';
session_start();
if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminstyle.css">
    <title>ROQS - Admin</title>
</head>
<body>
    <header class="header">
        <div class="container">
            <img src="logo1.png" alt="ROQS Logo" class="logo">
            <nav class="menu">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Inventory</a></li>
                    <li><a href="#">User Access</a></li>
                    <li><a href="#">Modifications</a></li>
                    <li><a href="logout.php">Exit</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main">
        <!-- Your main content goes here -->
    </main>
    <footer class="copyright">
        &copy; 2023 ROQS - Restaurant Ordering and Queuing System. All rights reserved.
    </footer>
</body>
</html>


