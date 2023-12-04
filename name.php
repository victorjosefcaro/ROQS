<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $partySize = $_POST["party-size"];

    // Perform database insertion (replace with your database logic)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "queuing_process";

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'queuing_process');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $sql = $conn->prepare("INSERT INTO reservation (name, party_size) VALUES (?, ?)");
    $sql->bind_param("si", $name, $partySize);

    // Execute the prepared statement
    $sql->execute();

    // Check for success
    if ($sql->affected_rows > 0) {
        echo "Reservation added successfully";
    } else {
        echo "Error: " . $sql->error;
    }

    // Close the statement and connection
    $sql->close();
    $conn->close();
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
    <form id="reservation-form" action="" method="post">
      <div class="container">
        <h1 class="name1">Table Reservation</h1>
        <label for="name">Your Name</label>
        <input
          type="text"
          id="name"
          name="name"
          autocomplete="name"
          placeholder="Type your name"
        />
        <label for="party-size">Party Size:</label>
        <input type="number" id="party-size" name="party-size" required />
      </div>
      <button class="btn" type="submit" id="add-customer-button">Queue</button>
    </form>

    <!-- Add the spacer with the .spacer class -->
    <div class="spacer"></div>
    <footer class="copyright">
      &copy; 2023 ROQS - Restaurant Ordering and Queuing System. All rights
      reserved.
    </footer>
    <script src="script1.js"></script>
  </body>
</html>
