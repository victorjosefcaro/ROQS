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
