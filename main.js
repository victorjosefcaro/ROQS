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

document.addEventListener("DOMContentLoaded", function () {
  const orderButtons = document.querySelectorAll('.order-btn');

  orderButtons.forEach((button) => {
      button.addEventListener('click', function () {
          const itemImageBase64 = this.getAttribute('data-item-image');
          const itemName = this.getAttribute('data-item-name');
          const itemPrice = this.getAttribute('data-item-price');

          document.getElementById('modalItemPrice').innerText = itemName;
          document.getElementById('modalItemName').innerText = itemName;
          document.getElementById('modalItemPrice').innerText = '₱ ' + itemPrice;

          const modalItemImage = document.getElementById('modalItemImage');
          modalItemImage.src = 'data:image/jpeg;base64,' + itemImageBase64;
          modalItemImage.alt = itemName + ' Image';
      });
  });
});