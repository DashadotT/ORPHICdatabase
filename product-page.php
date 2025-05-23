<!DOCTYPE html>
<html>

<head>
    <title>Orphic Checkout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        nav {
            width: 100%;
            background-color: #141d4e;
        }

        .navbar {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin: 0 15rem;
        }

        nav img {
            max-height: 60px;
            margin: 0 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
            font-weight: bold;
        }

        .navbar-links {
            display: flex;
            gap: 5rem;
        }

        .searchandcart {
            margin: 0 15rem;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            gap: 40px;
        }

        .search-bar {
            width: 950px;
            height: 50px;
        }

        .search-bar input[type="text"] {
            width: 100%;
            height: 100%;
            padding: 0 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 1em;
        }

        .cart-icon {
            font-size: 26px;
            cursor: pointer;
            color: #333;
            background-color: yellow;
            border-radius: 50%;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
        }

        main {
            margin: 2rem 15rem;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .section {
            background-color: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .section h2 {
            margin-bottom: 15px;
            color: #007bff;
        }

        .product-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .product-image {
            max-width: 160px;
            max-height: 160px;
            border-radius: 8px;
        }

        #product-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="tel"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        label {
            font-weight: 500;
        }

        .order-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .order-summary div {
            text-align: right;
        }

        .order-summary strong {
            font-weight: bold;
        }

        .payment-method label {
            display: block;
            margin-bottom: 10px;
        }

        #place-order {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #place-order:hover {
            background-color: #218838;
        }

        @media (max-width: 1000px) {
            main {
                margin: 1rem;
            }

            .container {
                grid-template-columns: 1fr;
            }
        }

        .orphic-footer {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 40px;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 60px 40px;
        }

        .footer-section {
            flex: 1 1 220px;
            margin: 15px;
        }

        .footer-section h3 {
            font-size: 16px;
            margin-bottom: 12px;
            color: #222;
        }

        .footer-section p {
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .footer-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer-icons img {
            height: 25px;
            max-width: 100px;
        }

        .footer-bottom {
            background-color: #e9eef6;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            font-size: 14px;
        }

        .footer-bottom .social {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-bottom .social span {
            font-weight: 600;
            margin-right: 5px;
        }

        .footer-bottom .social img {
            height: 20px;
            width: 20px;
        }

        #accountModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        #accountModalContent {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }

        #accountModal .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        #accountModal .close:hover,
        #accountModal .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <nav>
        <div class="navbar">
            <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo">
            <div class="navbar-links">
                <div>
                    <a href="Home.html">Home</a>
                    <a href="Home.html#product-list">Today's Deals</a>
                    <a href="orders.html">Orders</a>
                </div>
                <div>
                    <a href="#" id="openAccountModal">You</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            <div class="section" id="product-details">
                <div class="product-wrapper">
                    <img src="placeholder.jpg" alt="Product Image" class="product-image" id="product-image">
                    <h3 id="product-title"></h3>
                </div>
                <p id="product-price"></p>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" value="1" min="1">

                <h2>Shipping Address</h2>
                <label for="name">Name:</label>
                <input type="text" id="name">

                <label for="phone">Phone:</label>
                <input type="tel" id="phone">

                <label for="address">Address:</label>
                <textarea id="address" rows="3"></textarea>
            </div>

            <div class="section">
                <h2>Select Payment Method</h2>
                <div class="payment-method">
                    <label><input type="radio" name="payment" value="cash"> Cash on Delivery</label>
                    <label><input type="radio" name="payment" value="gcash"> GCash</label>
                    <label><input type="radio" name="payment" value="paymaya"> PayMaya</label>
                    <label><input type="radio" name="payment" value="bpi"> BPI</label>
                    <label><input type="radio" name="payment" value="paypal"> PayPal</label>
                </div>

                <h2>Order Summary</h2>
                <div class="order-summary">
                    <div>Subtotal (<span id="item-count">1</span> Items)</div>
                    <div id="subtotal">₱600.00</div>
                    <div>Shipping Fee</div>
                    <div id="shipping-fee">₱80.00</div>
                    <div><strong>Total:</strong></div>
                    <div id="total"><strong>₱680.00</strong></div>
                </div>

                <button id="place-order">Place Order</button>
            </div>
        </div>
    </main>

    <div id="accountModal">
        <div id="accountModalContent">
            <span class="close" onclick="closeAccountModal()">&times;</span>
            <h2>Your Account</h2>
            <p><strong>Name:</strong>Joeroz</p>
            <p><strong>Email:</strong>joerozvicariato@gmail.com</p>
            <p><strong>Member Since:</strong> 2023-10-26</p>
            <p><strong>Address:</strong>Lingion, Manolo Fortich Bukidnon</p>
            <p><strong>Phone:</strong>09123456789</p>
        </div>
    </div>

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
                    <img src="https://c.animaapp.com/maixeniyECsT9y/img/2go-travel-logo--2018--svg-1.png"
                        alt="2GO Express">
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
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg"
                        alt="Facebook"></a>
            </div>
            <p>&copy; Orphic2025. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');

        fetch('Home.json')
            .then(res => res.json())
            .then(products => {
                const product = products.find(p => p.id === productId);

                if (product) {
                    document.getElementById('product-title').textContent = product.title;
                    document.getElementById('product-price').textContent = '₱' + product.price;
                    document.getElementById('product-image').src = product.image;

                    document.getElementById('quantity').addEventListener('change', () => updateTotal(product.price));
                    document.getElementById('place-order').addEventListener('click', () => placeOrder(product));

                    updateTotal(product.price);
                } else {
                    document.getElementById('product-details').innerHTML = '<p>Product not found.</p>';
                }
            });

        function updateTotal(price) {
            const quantity = parseInt(document.getElementById('quantity').value);
            const subtotal = price * quantity;
            document.getElementById('subtotal').textContent = '₱' + subtotal;
            document.getElementById('total').innerHTML = `<strong>₱${subtotal + 80}</strong>`;
            document.getElementById('item-count').textContent = quantity;
        }

        function placeOrder(product) {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const paymentMethod = document.querySelector('input[name="payment"]:checked')?.value;
            const quantity = parseInt(document.getElementById('quantity').value);

            if (!name || !phone || !address || !paymentMethod || isNaN(quantity) || quantity <= 0) {
                alert("Please fill in all required fields.");
                return;
            }

            const order = {
                productId: product.id,
                productName: product.title,
                quantity: quantity,
                total: (product.price * quantity) + 80,
                paymentMethod: paymentMethod,
                shippingAddress: { name, phone, address },
                productImage: product.image // Add this line
            };

            let orders = JSON.parse(localStorage.getItem('orders')) || [];
            orders.push(order);
            localStorage.setItem('orders', JSON.stringify(orders));

            window.location.href = 'orders.html';
        }

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