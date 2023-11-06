// Adding a new table
document.getElementById("add-table-button").addEventListener("click", function() {
    const newTableID = document.getElementById("new-table-id").value;
    const newTableSeats = parseInt(document.getElementById("new-table-seats").value);

    if (newTableID && newTableSeats > 0) {
        // Add the new table to the tables array
        tables.push({ id: newTableID, status: "available", seats: newTableSeats });

        // Update the table display
        updateTableStatus();

        // Clear the input fields
        document.getElementById("new-table-id").value = "";
        document.getElementById("new-table-seats").value = "";
    } else {
        alert("Please provide a valid Table ID and the number of Seats.");
    }
});
