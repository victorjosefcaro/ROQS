<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="queuing.css" />
    <title>Queue Management</title>
  </head>
  <body>
    <div class="container1">
      <h1>Table Reservation</h1>
      <form id="reservation-form">
        <!-- Your reservation form fields go here -->
      </form>
    </div>

    <div class="container">
      <div class="tables">
        <!-- Your table display code goes here -->
      </div>

      <div class="add-table-section">
        <h2>Add a New Table</h2>
        <div class="tab">
          <input type="number" id="new-table-seats" placeholder="Seats" />
          <button id="add-table-button">Add Table</button>
          <!-- Add the "Delete Table" button here -->
          <button style="margin-left: 1rem" id="delete-table-button">
            Delete Table
          </button>
        </div>
      </div>
    </div>

    <div class="container">
      <h1>Queue Management</h1>
      <div class="queue-info">
        <h2>Customers in Queue: <span id="queue-count">0</span></h2>
      </div>
      <div class="queue">
        <ul id="customer-queue"></ul>
      </div>
      <button id="serve-customer-button">
        Serve Next Customer
      </button>
    </div>
    <script src="script.js"></script>
  </body>
</html>
