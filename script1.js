document.addEventListener("DOMContentLoaded", function () {
  const reservationForm = document.getElementById("reservation-form");
  const tablesContainer = document.querySelector(".tables");
  const customerQueue = [];
  const queueCountElement = document.getElementById("queue-count");
  const customerQueueElement = document.getElementById("customer-queue");
  const serveCustomerButton = document.getElementById("serve-customer-button");
  const makeAvailableButton = document.getElementById("make-available-button");

  const tables = [
    { id: 1, status: "available", seats: 2 },
    { id: 2, status: "occupied", seats: 4 },
    { id: 3, status: "available", seats: 6 },
    // Add more tables as needed
  ];

  serveCustomerButton.addEventListener("click", function () {
    if (customerQueue.length > 0) {
      // Serve the next customer in the queue
      const servedCustomer = customerQueue.shift();

      // Find an available table
      const table = findAvailableTable(servedCustomer.partySize);

      if (table) {
        // Assign the table to the customer
        table.status = "occupied";
        servedCustomer.table = table.id;

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
      .then(() => {
        // Assuming the reservation was successful, update the local queue
        const customer = {
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

      // Add the rest of the table's content
      tableDiv.innerHTML = `<h2> Table ${table.id}</h2><p>Status: ${table.status}</p><p>Seats: ${table.seats}</p>`;
      tableDiv.appendChild(makeAvailableButton);

      // Append the table to the container
      tablesContainer.appendChild(tableDiv);
    });
  }

  // Initialize the table status
  updateTableStatus();

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
        alert("Please provide a valid number of seats.");
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
});
