function editOrder() {
    var item_id = $('#modalItemId').text();
    var item_quantity = $('#amount').val();
    var item_requests = $('#itemRequests').val();

    $.ajax({
        type: 'POST',
        url: 'edit_order.php',
        data: {
            item_id: item_id,
            item_quantity: item_quantity,
            item_requests: item_requests
        },
        success: function (response) {
            // Handle success response if needed
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const orderButtons = document.querySelectorAll('.order-btn');
    const incrementButton = document.getElementById('increment');
    const decrementButton = document.getElementById('decrement');
    const deleteButton = document.getElementById('delete');
    const amountInput = document.getElementById('amount');
    const modalItemPrice = document.getElementById('modalItemPrice');

    orderButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const itemName = this.getAttribute('data-item-name');
            const itemId = this.getAttribute('data-item-id');
            const itemQuantity = this.getAttribute('data-item-quantity');
            const itemRequests = this.getAttribute('data-item-requests');
            itemPrice = parseFloat(this.getAttribute('data-item-price'));

            document.getElementById('modalItemId').innerText = itemId;
            document.getElementById('modalItemName').innerText = itemName;
            document.getElementById('modalItemPrice').innerText = '₱ ' + itemPrice * itemQuantity;
            document.getElementById('amount').value = itemQuantity;
            document.getElementById('itemRequests').innerText = itemRequests;
        });
    });
  

    // Increment button functionality
    incrementButton.addEventListener('click', function () {
        amountInput.value = parseInt(amountInput.value) + 1;
        updateTotalPrice();
    });

    // Decrement button functionality
    decrementButton.addEventListener('click', function () {
        // Prevent decrementing below 1
        if (parseInt(amountInput.value) > 1) {
            amountInput.value = parseInt(amountInput.value) - 1;
        }
        updateTotalPrice();
    });

    // Prevent manual entry of non-numeric values
    amountInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        updateTotalPrice();
    });

    // Update total price based on quantity
    function updateTotalPrice() {
        const quantity = parseInt(amountInput.value);
        const totalPrice = itemPrice * quantity;
        modalItemPrice.innerText = '₱ ' + totalPrice;
    }

    deleteButton.addEventListener('click', function () {
        var itemId = this.getAttribute('data-item-id'); // Get the item ID from the button
        var cardToRemove = this.closest('.card'); // Get the parent card element to be removed
    
        $.ajax({
            type: 'POST',
            url: 'delete_order.php', // Specify the URL for the delete operation
            data: {
                item_id: itemId // Pass the item ID to be deleted
            },
            success: function (response) {
                // Handle success response if needed
                console.log(response);
                // Remove the card representing the deleted item from the cart
                if (cardToRemove) {
                    cardToRemove.remove(); // Remove the card element
                }
                // You might update the cart count or perform other UI updates here
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    });

    // Event listener for Place Orders button
    $("#placeOrderBtn").click(function () {
        if (customerId) {
            // AJAX request to place the order with customer ID
            $.ajax({
                type: "POST",
                url: "place_orders.php",
                data: {
                    customer_id: customerId
                },
                success: function (response) {
                    console.log(response);
                    // You might want to perform UI updates here upon successful placement
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error scenarios or UI updates for failures
                }
            });
        } else {
            console.error("Customer ID not found");
        }
    });
});