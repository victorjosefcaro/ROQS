document.addEventListener("DOMContentLoaded", function () {
  const reservationForm = document.getElementById("reservation-form");
  const tablesContainer = document.querySelector(".tables");
  let customerQueue = [];
  const queueCountElement = document.getElementById("queue-count");
  const customerQueueElement = document.getElementById("customer-queue");
  const serveCustomerButton = document.getElementById("serve-customer-button");
  const makeAvailableButton = document.getElementById("make-available-button");

  const tables = [
    { id: 1, status: "available", seats: 2 },
    { id: 2, status: "available", seats: 4 },
    { id: 3, status: "available", seats: 6 },
    // Add more tables as needed
  ];

  // Check if the "makeAvailableButton" is defined before adding the event listener
  if (makeAvailableButton) {
    makeAvailableButton.addEventListener("click", function () {
      // Make the selected table available
      const tableIdToMakeAvailable = parseInt(
        prompt("Enter the table number to make available:")
      );

      const table = tables.find((table) => table.id === tableIdToMakeAvailable);

      if (table) {
        table.status = "available";

        // Clear the table assignment for the customer who occupied it
        const customer = customerQueue.find(
          (customer) => customer.table === tableIdToMakeAvailable
        );
        if (customer) {
          customer.table = null;
        }
      }

      // Update the display
      updateTableStatus();
      updateQueueDisplay();
    });
  }

  serveCustomerButton.addEventListener("click", function () {
    if (customerQueue.length > 0) {
      // Serve the next customer in the queue
      const servedCustomer = customerQueue.shift();

      // Find an available table
      const table = findAvailableTable(servedCustomer.partySize);

      if (table) {
        // Assign the table to the customer
        table.status = "occupied";
        servedCustomer.table = table.customer_id;

        // Save the served customer to a different table in the database
        saveServedCustomerToDatabase(servedCustomer);

        // Delete the served customer from the original table
        deleteServedCustomer(servedCustomer.id);

        // Update the display
        updateTableStatus();
        updateQueueDisplay();
      } else {
        // Error handling: No suitable table found
        alert("No suitable table found for the customer's party size.");

        // Optionally, you can add the customer back to the queue.
        customerQueue.push(servedCustomer);
        updateQueueDisplay();
      }
    }
  });

  function saveServedCustomerToDatabase(customer) {
    const formData = new FormData();
    formData.append("customer_id", customer.id);
    formData.append("name", customer.name);
    formData.append("party_size", customer.partySize);

    // Use AJAX to submit the form data
    fetch("save_served_customer.php", {
      method: "POST",
      body: formData,
    })
      .then(handleResponse)
      .then((data) => {
        console.log("Served customer saved to database:", data);
      })
      .catch(handleError);
  }

  function deleteServedCustomer(customerId) {
    // Make an AJAX request to delete the served customer
    fetch(`delete_customer.php?customer_id=${customerId}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          console.log("Served customer deleted successfully.");
        } else {
          console.error("Error deleting served customer.");
        }
      })
      .catch((error) => {
        console.error("Error deleting served customer:", error);
      });
  }

  function updateQueueDisplay() {
    // Update the number of customers in the queue
    queueCountElement.textContent = customerQueue.length;

    // Update the customer queue list
    customerQueueElement.innerHTML = "";
    customerQueue.forEach((customer) => {
      const customerItem = document.createElement("li");
      customerItem.textContent = customer.name;
      customerQueueElement.appendChild(customerItem);
    });
  }

  reservationForm.addEventListener("submit", function (event) {
    event.preventDefault();

    // Validate form input
    const nameInput = document.getElementById("name");
    const partySizeInput = document.getElementById("party-size");

    if (!nameInput.value || isNaN(parseInt(partySizeInput.value))) {
      alert("Please provide valid input.");
      return;
    }

    const formData = new FormData(reservationForm);

    // Use AJAX to submit the form data
    fetch(reservationForm.action, {
      method: "POST",
      body: formData,
    })
      .then(handleResponse)
      .then((data) => {
        // Assuming the reservation was successful, update the local queue
        const customer = {
          id: data.id, // Use the actual property from your response
          name: formData.get("name"),
          partySize: parseInt(formData.get("party-size")),
        };
        customerQueue.push(customer);

        // Clear the reservation form
        nameInput.value = "";
        partySizeInput.value = 2; // Reset party size

        // Update the display
        updateQueueDisplay();
      })
      .catch(handleError);
  });

  // Fetch existing reservations from the server
  function fetchExistingReservations() {
    console.log("Fetching reservations...");
    fetch("fetch_reservations.php")
      .then((response) => response.json())
      .then((data) => {
        console.log("Received data:", data);
        // Assuming data is an array of reservations
        data.forEach((reservation) => {
          customerQueue.push({
            id: reservation.customer_id, // Use the actual property from your response
            name: reservation.name,
            partySize: reservation.party_size,
          });
        });

        // Update the display
        updateQueueDisplay();
      })
      .catch((error) => {
        console.error("Error fetching reservations:", error);
      });
  }

  // Fetch existing reservations when the page loads
  fetchExistingReservations();

  // Refresh data every 5 seconds (adjust the interval as needed)
  setInterval(refreshData, 5000);

  // Function to fetch reservations and update the queue
  function refreshData() {
    fetch("fetch_reservations.php")
      .then((response) => response.json())
      .then((data) => {
        // Clear existing data in customerQueue
        customerQueue = [];

        // Assuming data is an array of reservations
        data.forEach((reservation) => {
          customerQueue.push({
            id: reservation.customer_id, // Use the actual property from your response
            name: reservation.name,
            partySize: reservation.party_size,
          });
        });

        // Update the display
        updateQueueDisplay();
      })
      .catch((error) => {
        console.error("Error fetching reservations:", error);
      });
  }

  function handleResponse(response) {
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return response.text();
  }

  function handleError(error) {
    console.error("Error:", error);
    alert("An error occurred. Please try again.");
  }

  function handleNonAjaxError(error) {
    console.error("Non-AJAX Error:", error);
    // Perform any necessary actions for non-AJAX errors
    alert("An error occurred. Please try again.");
  }

  function findAvailableTable(partySize) {
    return tables.find(
      (table) => table.status === "available" && table.seats >= partySize
    );
  }

  function updateTableStatus() {
    tablesContainer.innerHTML = "";
    tables.forEach((table) => {
      const tableDiv = document.createElement("div");
      tableDiv.className = `table ${table.status}`;

      // Create the button element
      const makeAvailableButton = document.createElement("button");
      makeAvailableButton.textContent = "Make Table Available";
      makeAvailableButton.addEventListener("click", function () {
        // Make the selected table available
        table.status = "available";

        // Clear the table assignment for the customer who occupied it
        const customer = customerQueue.find(
          (customer) => customer.table === table.id
        );
        if (customer) {
          customer.table = null;
        }

        // Update the display
        updateTableStatus();
        updateQueueDisplay();
      });

      // Include the customer's name if the table is occupied
      if (table.status === "occupied") {
        const occupiedCustomer = customerQueue.find(
          (customer) => customer.table === table.id
        );
        if (occupiedCustomer) {
          // Debugging: Log the occupiedCustomer and tableDiv.innerHTML
          console.log("Occupied customer:", occupiedCustomer);
          console.log("Table content before:", tableDiv.innerHTML);

          // Append the customer's name to the table content
          tableDiv.innerHTML += `<p>Occupied by: ${occupiedCustomer.name}</p>`;

          // Debugging: Log the updated tableDiv.innerHTML
          console.log("Table content after:", tableDiv.innerHTML);
        }
      }

      // Add the rest of the table's content
      tableDiv.innerHTML += `<h2> Table ${table.id}</h2><p>Status: ${table.status}</p><p>Seats: ${table.seats}</p>`;

      // Append the button
      tableDiv.appendChild(makeAvailableButton);

      // Append the table to the container
      tablesContainer.appendChild(tableDiv);
    });
  }

  // Initialize the table status
  updateTableStatus();

  function deleteTable(tableIdToDelete) {
    const tableIndex = tables.findIndex(
      (table) => table.id === tableIdToDelete
    );

    if (tableIndex !== -1) {
      // Remove the table from the array
      tables.splice(tableIndex, 1);

      // Update table IDs
      updateTableIDs();

      // Update the display
      updateTableStatus();
    }
  }

  document
    .getElementById("delete-table-button")
    .addEventListener("click", function () {
      // Prompt the user to enter the table number to delete
      const tableIdToDelete = parseInt(
        prompt("Enter the table number to delete:")
      );

      // Check if the entered value is a valid number
      if (!isNaN(tableIdToDelete)) {
        // Call the deleteTable function
        deleteTable(tableIdToDelete);
      } else {
        handleNonAjaxError(new Error("Invalid table number entered."));
      }
    });

  // Adding a new table
  document
    .getElementById("add-table-button")
    .addEventListener("click", function () {
      const newTableSeats = parseInt(
        document.getElementById("new-table-seats").value
      );
      let newTableID;

      if (newTableSeats > 0) {
        // Generate a new table ID automatically by finding the highest existing ID
        const maxTableID = Math.max(...tables.map((table) => table.id));
        newTableID = maxTableID + 1;
      } else {
        handleNonAjaxError(
          new Error("Please provide a valid number of seats.")
        );
        return; // Exit the function early if there's an error
      }

      // Add the new table to the tables array
      tables.push({
        id: newTableID,
        status: "available",
        seats: newTableSeats,
      });

      // Update the table display
      updateTableStatus();

      // Clear the input field for seats
      document.getElementById("new-table-seats").value = "";
    });

  function updateTableIDs() {
    // Update table IDs based on the current order in the array
    tables.forEach((table, index) => {
      table.id = index + 1;
    });
  }

  // Initialize the table status
  updateTableStatus();
});
