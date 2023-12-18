let cartItems = [];
let total = 0;

function addToCart(productName, price) {
  cartItems.push({ name: productName, price: price });
  total += price;
  displayCart();
}

function displayCart() {
  const cartList = document.getElementById('cart-items');
  const cartTotal = document.getElementById('cart-total');
  cartList.innerHTML = '';
  
  cartItems.forEach(item => {
    const li = document.createElement('li');
    li.textContent = `${item.name} - $${item.price.toFixed(2)}`;
    cartList.appendChild(li);
  });

  cartTotal.textContent = total.toFixed(2);
}

function checkout() {
  // Here you can add logic for processing the checkout, such as sending the cart data to a server or displaying a confirmation message
  alert('Thank you for your purchase!');
  // Clear the cart after checkout
  cartItems = [];
  total = 0;
  displayCart();
}
