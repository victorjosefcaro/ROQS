<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "roqsmain";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user inputs
    $name = $conn->real_escape_string($_POST['name']);
    $size = $conn->real_escape_string($_POST['partysize']);

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO reservations (name, party_size) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $size);

    if ($stmt->execute()) {
        $response = "Data successfully inserted into the database.";
        header("Location: waiting.php"); // Redirect to the waiting page
    } else {
        $response = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Check if it's an AJAX request and return appropriate response
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo $response;
        exit;  // Terminate script after sending AJAX response
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />

    <title>ROQS - Restaurant Ordering and Queuing System</title>
  </head>
  <body>
    <h1>Table Reservation</h1>
    <form id="userForm" method="post" action="">
        <label for="name">Your Name</label><br />
        <input type="text" id="name" name="name" placeholder="Type your name" required />
        <br /><br />
        <label for="partysize">Party Size</label><br />
        <input type="number" id="partysize" name="partysize" required />
        <br /><br />
        <input id="queue-button" class="btn" type="submit" value="Queue" onclick="distrans()"/>
    </form>

    <!-- Add the spacer with the .spacer class -->
    <div class="spacer"></div>
    <footer class="copyright">
        &copy; 2023 ROQS - Restaurant Ordering and Queuing System. All rights reserved.
    </footer>
    <script src="script.js"></script>
  </body>
</html>

