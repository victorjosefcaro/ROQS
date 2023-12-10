document.addEventListener("DOMContentLoaded", function () {
  const tablesContainer = document.querySelector(".tables");
  let customerQueue = [];
  let tables = [];
  const queueCountElement = document.getElementById("queue-count");
  const customerQueueElement = document.getElementById("customer-queue");
  const makeAvailableButton = document.getElementById("make-available-button");

  document
    .getElementById("serve-customer-button")
    .addEventListener("click", serveNextCustomer);

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
      updateLocalStorage();
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

  let nextCustomer; // Declare nextCustomer in a broader scope

  function serveNextCustomer() {
    // Check if there are customers in the queue
    if (customerQueue.length > 0) {
      nextCustomer = customerQueue.shift(); // Get the next customer
      const availableTable = findAvailableTable(nextCustomer.partySize);

      if (availableTable) {
        // Assign the table to the customer
        nextCustomer.table = availableTable.id;
        availableTable.status = "occupied";

        // Update the display
        updateTableStatus();
        updateQueueDisplay();

        // Optionally: You can save the customerQueue to localStorage
        localStorage.setItem("customerQueue", JSON.stringify(customerQueue));

        // Send AJAX request to save customer data to the database
        saveCustomerToDatabase(nextCustomer);
        deleteServedCustomer(nextCustomer.id);
      } else {
        alert(
          "No available table for the next customer. Please try again later."
        );
      }
    } else {
      alert("No customers in the queue.");
    }
  }

  function saveCustomerToDatabase(customer) {
    const formData = new FormData();
    formData.append("name", customer.name);
    formData.append("party_size", customer.partySize);

    fetch("save_served_customer.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          console.log("Customer saved successfully.");
        } else {
          console.error("Error saving customer:", data.message);

          // Display an alert if the customer was not served successfully
          alert(
            "Customer was not served. There might be an issue. Please try again."
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  function showButton() {
    button.style.display = "block"; // Change to "inline" if it's an inline element like a span
  }

  function deleteServedCustomer(customerId) {
    // Check if nextCustomer is defined
    if (nextCustomer) {
      // Make an AJAX request to delete the served customer
      fetch(`delete_customer.php?reservation_id=${customerId}`)
        .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          if (data.status === "success") {
            console.log("Served customer deleted successfully.");

            // Update local storage
            const updatedCustomerQueue = customerQueue.filter(
              (customer) => customer.id !== customerId
            );
            localStorage.setItem(
              "customerQueue",
              JSON.stringify(updatedCustomerQueue)
            );
          } else {
            console.error("Error deleting served customer.");
          }
        })
        .catch((error) => {
          console.error("Error deleting served customer:", error);
        });
    } else {
      console.error("nextCustomer is not defined.");
    }
  }

  function fetchExistingData() {
    const storedQueue = localStorage.getItem("customerQueue");
    const storedTables = localStorage.getItem("tables");

    if (storedQueue) {
      customerQueue = JSON.parse(storedQueue);
    }

    if (storedTables) {
      tables = JSON.parse(storedTables);
    } else {
      // Initialize tables if not present in local storage
      tables = [
        { id: 1, status: "available", seats: 2 },
        { id: 2, status: "available", seats: 2 },
        { id: 3, status: "available", seats: 4 },
        { id: 4, status: "available", seats: 4 },
        { id: 5, status: "available", seats: 6 },
        { id: 6, status: "available", seats: 6 },
        // Add more tables as needed
      ];
    }

    // Update the display after loading data
    updateTableStatus();
    updateQueueDisplay();
  }

  // Fetch existing reservations and table data when the page loads
  fetchExistingData();

  // Fetch existing reservations from the server
  function fetchExistingReservations() {
    console.log("Fetching reservations...");
    const storedData = localStorage.getItem("customerQueue");

    if (storedData) {
      customerQueue = JSON.parse(storedData);
    } else {
      // Fetch from the server if localStorage is empty
      fetch("fetch_reservations.php")
        .then((response) => response.json())
        .then((data) => {
          console.log("Received data:", data);
          // Assuming data is an array of reservations
          data.forEach((reservations) => {
            customerQueue.push({
              id: reservations.reservation_id, // Use the actual property from your response
              name: reservations.name,
              partySize: reservations.party_size,
            });
          });

          // Update the display
          updateQueueDisplay();
        })
        .catch((error) => {
          console.error("Error fetching reservations:", error);
        });
    }
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
        data.forEach((reservations) => {
          customerQueue.push({
            id: reservations.reservation_id, // Use the actual property from your response
            name: reservations.name,
            partySize: reservations.party_size,
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
        updateLocalStorage();
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
    updateLocalStorage();
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

  function updateLocalStorage() {
    localStorage.setItem("customerQueue", JSON.stringify(customerQueue));
    localStorage.setItem("tables", JSON.stringify(tables));
  }

  function clearLocalStorage() {
    localStorage.removeItem("customerQueue");
    localStorage.removeItem("tables");
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
      updateLocalStorage();
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
      updateLocalStorage();
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
