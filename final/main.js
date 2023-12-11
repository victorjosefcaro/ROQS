function filterItems(category) {
    let items = document.querySelectorAll('.flex-column');
    items.forEach(item => {
        let category_name = item.querySelector('.card-title:nth-child(2)').textContent.trim();
        if (category === 'All' || category_name === category) {
            item.style.display = 'flex'; // Show items that match the category or 'All'
        } else {
            item.style.display = 'none'; // Hide items that don't match the category
        }
    });
}

function searchItems() {
    let input = document.querySelector('.form-control');
    let filter = input.value.toUpperCase();
    let category = document.querySelector('input[name="options-outlined"]:checked').id;

    let items = document.querySelectorAll('.flex-column');
    items.forEach(item => {
        let itemName = item.querySelector('.card-title:nth-child(1)').textContent.toUpperCase();
        let category_name = item.querySelector('.card-title:nth-child(2)').textContent.trim();

        if ((category === '1' || category_name === getCategoryNameFromId(category)) && itemName.includes(filter)) {
            item.style.display = 'flex'; // Show items that match the search query and category
        } else {
            item.style.display = 'none'; // Hide items that don't match the search query or category
        }
    });
}

// Helper function to get category name from ID
function getCategoryNameFromId(categoryId) {
    switch (categoryId) {
        case '1':
            return 'All';
        case '2':
            return 'Appetizer';
        case '3':
            return 'Entree';
        case '4':
            return 'Side';
        case '5':
            return 'Dessert';
        case '6':
            return 'Beverage';
        default:
            return '';
    }
}

function placeOrder() {
    var item_id = $('#modalItemId').text();
    var item_quantity = $('#amount').val();
    var item_requests = $('#itemRequests').val();

    $.ajax({
        type: 'POST',
        url: 'place_order.php',
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
    const amountInput = document.getElementById('amount');
    const modalItemPrice = document.getElementById('modalItemPrice');

    let itemPrice = 0;

    orderButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const itemImageBase64 = this.getAttribute('data-item-image');
            const itemName = this.getAttribute('data-item-name');
            const itemId = this.getAttribute('data-item-id');
            itemPrice = parseFloat(this.getAttribute('data-item-price'));

            document.getElementById('modalItemId').innerText = itemId;
            document.getElementById('modalItemName').innerText = itemName;
            modalItemPrice.innerText = '₱ ' + itemPrice;

            amountInput.value = 1;

            document.getElementById('modalItemPrice').innerText = itemName;
            document.getElementById('modalItemName').innerText = itemName;
            document.getElementById('modalItemPrice').innerText = '₱ ' + itemPrice;

            const modalItemImage = document.getElementById('modalItemImage');
            modalItemImage.src = 'data:image/jpeg;base64,' + itemImageBase64;
            modalItemImage.alt = itemName + ' Image';
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
});