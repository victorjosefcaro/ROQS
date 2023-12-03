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
    <form  id="reservation-form">
      <div class="container">
        <h1 class="name1">Table Reservation</h1>
        <div class="form-group">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" autocomplete="name" placeholder="Type your name">
        </div>

        <div class="form-group">
          <label for="party-size">Party Size:</label>
          <input type="number" value="2" id="party-size" required>
        </div>

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
