<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orphic Orders</title>
  <link rel="stylesheet" href="orders.css" />
</head>

<body>

  <!-- Navbar -->
  <nav>
    <div class="navbar">
      <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo">
      <div class="navbar-links">
        <div>
          <a href="Home.php">Home</a>
          <a href="Home.php#product-list">Today's Deals</a>
          <a href="orders.php">Orders</a>
        </div>
        <div>
          <a href="#" id="openAccountModal">You</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="searchandcart">
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search...">
    </div>
    <a href="Cart.php">
      <span class="cart-icon">&#128722;</span>
    </a>
  </div>

  <!-- Page Header -->

  <!-- Account Modal -->
<div id="accountModal">
  <div id="accountModalContent">
    <span class="close" onclick="closeAccountModal()">&times;</span>
    <h2>Your Account</h2>
    <p><strong>Name:</strong> Joeroz</p>
    <p><strong>Email:</strong> joerozvicariato@gmail.com</p>
    <p><strong>Member Since:</strong> 2023-10-26</p>
    <p><strong>Address:</strong> Lingion, Manolo Fortich Bukidnon</p>
    <p><strong>Phone:</strong> 09123456789</p>
    <button onclick="logout()">Log Out</button>
  </div>
</div>

<!-- JavaScript -->
<script>
  function closeAccountModal() {
    document.getElementById("accountModal").style.display = "none";
  }

  function logout() {
    // Optional: clear session/local storage
    // sessionStorage.clear(); localStorage.clear();

    // Redirect to your existing login form/page
    window.location.href = "login.php"; // change to your actual login page
  }
</script>

  <!-- Orders Section -->

  <main>
    <header>
      <h1>Orders</h1>
    </header>
    <ul id="order-list"></ul>
  </main>



  <!-- Footer -->
  <footer class="orphic-footer">
    <div class="footer-container">
      <div class="footer-section about">
        <h3>ABOUT US</h3>
        <p>ORPHIC is an eCommerce platform based in the Philippines, designed to serve the growing community of
          PC builders, gamers, and tech enthusiasts. It empowers users to build their own custom PCs with
          confidence by offering essential tools. ORPHIC aims to become the go-to destination for reliable,
          beginner-friendly PC building solutions that combine both function and convenience.</p>
      </div>

      <div class="footer-section payments">
        <h3>PAYMENT METHODS</h3>
        <div class="footer-icons">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/gcash-logo-500x281-1.png" alt="GCash">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/image-5.png" alt="PayMaya">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/image-6.png" alt="BPI">
          <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
        </div>
      </div>

      <div class="footer-section logistics">
        <h3>LOGISTICS</h3>
        <div class="footer-icons">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/flash-express-malaysia-1634103999-removebg-preview-1.png"
            alt="Flash Express">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/648px-j-t-express-logo-svg-removebg-preview-1.png"
            alt="J&T Express">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/ninjavan-svg-1.png" alt="Ninja Van">
          <img src="https://c.animaapp.com/maixeniyECsT9y/img/2go-travel-logo--2018--svg-1.png" alt="2GO Express">
        </div>
      </div>

      <div class="footer-section service">
        <h3>CUSTOMER SERVICE</h3>
        <ul>
          <li><a href="#">Help Centre</a></li>
          <li><a href="#">Payment Methods</a></li>
          <li><a href="#">Order Tracking</a></li>
          <li><a href="#">Free Shipping</a></li>
          <li><a href="#">Return & Refund</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="social">
        <span>FOLLOW US</span>
        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png"
            alt="Instagram"></a>
        <a href="#"><img src="https://c.animaapp.com/maixeniyECsT9y/img/image-9.png" alt="Twitter"></a>
        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png"
            alt="LinkedIn"></a>
        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg" alt="Facebook"></a>
      </div>
      <p>&copy; Orphic2025. All rights reserved.</p>
    </div>
  </footer>

  <script>
    const orderList = document.getElementById('order-list');
    const searchInput = document.getElementById('searchInput');

    function renderOrders(filter = "") {
      orderList.innerHTML = '';
      const orders = JSON.parse(localStorage.getItem('orders')) || [];

      const filteredOrders = orders.filter(order =>
        order.productName.toLowerCase().includes(filter.toLowerCase())
      );

      if (filteredOrders.length === 0) {
        const emptyMessage = document.createElement('li');
        emptyMessage.textContent = "No orders found.";
        orderList.appendChild(emptyMessage);
        return;
      }

      filteredOrders.forEach((order, index) => {
        const listItem = document.createElement('li');
        listItem.classList.add('order-card');
        listItem.dataset.index = index;

        listItem.innerHTML = `
        <img src="${order.productImage || 'https://via.placeholder.com/90'}" alt="${order.productName}">
        <div class="order-details">
          <p><strong>Product:</strong> ${order.productName}</p>
          <p><strong>Quantity:</strong> ${order.quantity}</p>
          <p><strong>Total:</strong> ₱${order.total}</p>
          <p><strong>Payment Method:</strong> ${order.paymentMethod}</p>
        </div>
        <div class="order-actions">
          <button class="cancel-button" data-index="${index}">Cancel</button>
        </div>
      `;
        orderList.appendChild(listItem);
      });
    }

    orderList.addEventListener('click', (event) => {
      if (event.target.classList.contains('cancel-button')) {
        const index = parseInt(event.target.dataset.index);
        let orders = JSON.parse(localStorage.getItem('orders')) || [];
        if (confirm('Are you sure you want to cancel this order?')) {
          orders.splice(index, 1);
          localStorage.setItem('orders', JSON.stringify(orders));
          renderOrders(searchInput.value);
        }
      }
    });

    // 🔍 Add event listener for search
    searchInput.addEventListener('input', (e) => {
      renderOrders(e.target.value);
    });

    renderOrders(); // Initial load

    const accountModal = document.getElementById('accountModal');
    const openAccountModalButton = document.getElementById('openAccountModal');

    openAccountModalButton.addEventListener('click', () => {
      accountModal.style.display = 'block';
    });

    // ... (Your existing JavaScript code) ...

    function closeAccountModal() {
      accountModal.style.display = "none";
    }

    const closeButton = document.querySelector('#accountModal .close'); //Get the close button using querySelector
    closeButton.addEventListener('click', closeAccountModal); //Add an event listener to it.

    // ... (rest of your existing JavaScript code) ...
    //Close the modal when clicking outside of it.
    window.onclick = function (event) {
      if (event.target == accountModal) {
        accountModal.style.display = "none";
      }
    }
  </script>

</body>

</html>