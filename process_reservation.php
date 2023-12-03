<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $partySize = $_POST["party-size"];

    // Perform database insertion (replace with your database logic)
    $servername = "your_server_name";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database (replace with your table and column names)
    $sql = "INSERT INTO reservation (name, party_size) VALUES ('$name', $partySize)";

    if ($conn->query($sql) === TRUE) {
        echo "Reservation added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
