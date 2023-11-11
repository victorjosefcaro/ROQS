class Item {
  constructor(name, description, price, category) {
    this.name = name;
    this.description = description;
    this.price = price;
    this.category = category;
  }
}

var currency = "₱";

const item1 = new Item(
  "Sample Item 1",
  "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas sed quas fuga alias natus exercitationem ad porro, magnam sit veniam in asperiores eaque.",
  500,
  "Sample Category 1"
);
const item2 = new Item(
  "Sample Item 2",
  "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas sed quas fuga alias natus exercitationem ad porro, magnam sit veniam in asperiores eaque.",
  300,
  "Sample Category 1"
);
const item3 = new Item(
  "Sample Item 3",
  "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas sed quas fuga alias natus exercitationem ad porro, magnam sit veniam in asperiores eaque.",
  250,
  "Sample Category 2"
);
const item4 = new Item(
  "Sample Item 4",
  "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas sed quas fuga alias natus exercitationem ad porro, magnam sit veniam in asperiores eaque.",
  400,
  "Sample Category 2"
);
const item5 = new Item(
  "Sample Item 5",
  "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas sed quas fuga alias natus exercitationem ad porro, magnam sit veniam in asperiores eaque.",
  500,
  "Sample Category 3"
);

document.getElementById("itemName1").textContent = item1.name;
document.getElementById("itemName2").textContent = item2.name;
document.getElementById("itemName3").textContent = item3.name;
document.getElementById("itemName4").textContent = item4.name;
document.getElementById("itemName5").textContent = item5.name;

document.getElementById("itemDescription1").textContent = item1.description;
document.getElementById("itemDescription2").textContent = item2.description;
document.getElementById("itemDescription3").textContent = item3.description;
document.getElementById("itemDescription4").textContent = item4.description;
document.getElementById("itemDescription5").textContent = item5.description;

document.getElementById("itemPrice1").textContent = item1.price;
document.getElementById("itemPrice2").textContent = item2.price;
document.getElementById("itemPrice3").textContent = item3.price;
document.getElementById("itemPrice4").textContent = item4.price;
document.getElementById("itemPrice5").textContent = item5.price;

function populateModal(itemName, itemDescription, itemPrice) {
  document.getElementById("modalItemName").textContent = itemName;
  document.getElementById("modalItemDescription").textContent = itemDescription;
  document.getElementById("modalItemPrice").textContent = itemPrice;
  document.getElementById("modalItemTotalPrice").textContent = itemPrice;
}

// Get the input element and the increment/decrement buttons
const amountInput = document.getElementById("amountInput");
const incrementButton = document.getElementById("increment");
const decrementButton = document.getElementById("decrement");
const itemPrice = document.getElementById("modalItemPrice");
const itemTotalPrice = document.getElementById("modalItemTotalPrice");
const itemRequests = document.getElementById("itemRequests");

// Set default value to 1
amountInput.value = 1;

// Add event listeners to the buttons
incrementButton.addEventListener("click", () => {
  if (!isNaN(amountInput.value) && parseInt(amountInput.value) < 99) {
    amountInput.value = parseInt(amountInput.value) + 1;
  } else {
    amountInput.value = 99;
  }
  updateTotalPrice();
});

decrementButton.addEventListener("click", () => {
  if (!isNaN(amountInput.value) && parseInt(amountInput.value) > 1) {
    amountInput.value = parseInt(amountInput.value) - 1;
  } else {
    amountInput.value = 1;
  }
  updateTotalPrice();
});

// Add event listener to the input field to allow only numeric input
amountInput.addEventListener("input", () => {
  // Remove non-numeric characters from the input value
  amountInput.value = amountInput.value.replace(/\D/g, "");

  // Ensure the value is within the range of 1 to 99
  if (amountInput.value === "" || parseInt(amountInput.value) < 1) {
    amountInput.value = 1;
  } else if (parseInt(amountInput.value) > 99) {
    amountInput.value = 99;
  }
  updateTotalPrice();
});

// Function to update total price based on item price and input amount
function updateTotalPrice() {
  const totalPrice =
    parseInt(itemPrice.textContent) * parseInt(amountInput.value);
  // Assuming itemPrice is a text element, update its content with the calculated total price
  itemTotalPrice.textContent = totalPrice;
}

const closeModalButton = document.getElementById("closeModalButton");

// Add an event listener to the modal close button
closeModalButton.addEventListener("click", function () {
  // Reset the values when the modal is closed
  amountInput.value = 1;
  itemRequests.value = "";
});

// Create an array to store items in the cart
let cart = [];

// Function to add an item to the cart
function addToCart(itemName, itemDescription, itemPrice, quantity, totalPrice, requests) {
  const cartItem = {
    name: itemName,
    description: itemDescription,
    price: itemPrice,
    quantity: quantity,
    total: totalPrice,
    requests: requests,
  };
  cart.push(cartItem);
}

// Function to display items in the cart
function displayCart() {
  const offcanvasBody = document.querySelector('.offcanvas-body');
  offcanvasBody.innerHTML = ''; // Clear the existing content

  // Loop through the items in the cart and create card elements
  cart.forEach((item, index) => {
    const card = document.createElement('div');
    card.classList.add('card');
    card.style.marginBottom = '10px';

    const cardHeader = document.createElement('h5');
    cardHeader.classList.add('card-header');
    cardHeader.textContent = item.name;

    const container = document.createElement('div');
    container.classList.add('container');

    const row = document.createElement('div');
    row.classList.add('row');

    const col1 = document.createElement('div');
    col1.classList.add('col');
    const img = document.createElement('img');
    img.src = "salad.png"; // Replace with the actual image source
    img.classList.add('card-img');
    col1.appendChild(img);

    const col2 = document.createElement('div');
    col2.classList.add('col');
    const amountText = document.createElement('p');
    amountText.classList.add('card-text');
    amountText.textContent = `Amount: ${item.quantity}`;
    const priceText = document.createElement('p');
    priceText.classList.add('card-text');
    priceText.textContent = `Price: ${currency}${item.price}`;
    const totalPriceText = document.createElement('p');
    totalPriceText.classList.add('card-text');
    totalPriceText.textContent = `Total Price: ${currency}${item.total}`;
    col2.appendChild(amountText);
    col2.appendChild(priceText);
    col2.appendChild(totalPriceText);

    row.appendChild(col1);
    row.appendChild(col2);
    container.appendChild(row);

    const btnGroup = document.createElement('div');
    btnGroup.classList.add('btn-group', 'd-flex');
    const modifyButton = document.createElement('button');
    modifyButton.type = 'button';
    modifyButton.classList.add('btn', 'btn-dark', 'm-2', 'rounded');
    modifyButton.textContent = 'Modify';
    // Add event listener or onclick function for modifyButton

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('btn', 'btn-danger', 'm-2', 'rounded');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', () => {
      // Remove the item from the cart
      cart.splice(index, 1);
      // Update the display
      displayCart();
    });

    btnGroup.appendChild(modifyButton);
    btnGroup.appendChild(deleteButton);

    card.appendChild(cardHeader);
    card.appendChild(container);
    card.appendChild(btnGroup);

    offcanvasBody.appendChild(card);
  });
}

// Function to handle the "Place Order" button click
function placeOrder() {
  const itemName = document.getElementById("modalItemName").textContent;
  const itemDescription = document.getElementById("modalItemDescription").textContent;
  const itemPrice = parseInt(document.getElementById("modalItemPrice").textContent);
  const quantity = parseInt(document.getElementById("amountInput").value);
  const totalPrice = parseInt(document.getElementById("modalItemTotalPrice").textContent);
  const requests = document.getElementById("itemRequests").value;

  addToCart(itemName, itemDescription, itemPrice, quantity, totalPrice, requests);
  displayCart();
}

// Add an event listener to the "Place Order" button
const placeOrderButton = document.getElementById("placeOrderButton");
placeOrderButton.addEventListener("click", placeOrder);