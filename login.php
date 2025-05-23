<?php
require_once 'connection.php';
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="login.css" />
    <!-- <script>
      // Function to handle login
      function handleLogin(event) {
        event.preventDefault();  // Prevent form from submitting the default way

        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        if (!emailInput || !passwordInput) {
          alert('Login form elements not found.');
          return;
        }

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        // Basic validation for empty fields
        if (email && password) {
          // Store login information in localStorage
          localStorage.setItem('isLoggedIn', 'true');
          localStorage.setItem('userEmail', email);

          // Redirect to the homepage or any other page
          window.location.href = 'home.html';  // Changed to 'home.html'
        } else {
          alert('Please enter both email and password.');
        }
      }

      // Function to check login status on page load
      function checkLoginStatus() {
        const isLoggedIn = localStorage.getItem('isLoggedIn');
        const userEmail = localStorage.getItem('userEmail');
        const loginStatus = document.getElementById('loginStatus');  // Assuming you want to show login status

        if (isLoggedIn === 'true' && userEmail && loginStatus) {
          loginStatus.textContent = `Logged in as: ${userEmail}`;
        }
      }

      // Function to handle logout
      function handleLogout() {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('userEmail');
        window.location.href = 'login.html'; // Redirect to login page after logging out
      }

      // Event listener for login form submission
      document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
          loginForm.addEventListener('submit', handleLogin);
        }

        checkLoginStatus(); // Optional: Check login status if user is already logged in
      });
    </script> -->
  </head>
  <body>
    <div class="log-inpage">
      <div class="div">
        <div class="overlap">
          <div class="text-wrapper">FOLLOW US</div>
          <p class="p">© Orphic2025. All rights reserved.</p>
          <div class="group">
            <img class="image" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-5-1.png" />
            <img class="img" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-10.png" />
            <img class="image-2" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-8.png" />
            <img class="image-3" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-9.png" />
          </div>
        </div>
        <div class="overlap-group">
          <div class="login-BG"></div>
          <header class="header">
            <img class="logo" src="https://c.animaapp.com/mabuwas1L7eP4e/img/logo-1.png" />
            <div class="text-wrapper-2">Help?</div>
          </header>
          <img class="mask-group" src="https://c.animaapp.com/mabuwas1L7eP4e/img/mask-group.png" />
          <div class="rectangle"></div>
          <img class="mask-group-2" src="https://c.animaapp.com/mabuwas1L7eP4e/img/mask-group-1.png" />
          <div class="login-box">
            <form  action="auth.php" method="post" id="loginForm" class="overlap-group-2">
              <div class="overlap-2">
                <input type="text" name="username" id="email" class="rectangle-2" placeholder="Email / Phone number" required />
              </div>
              
              <div class="overlap-3">
                <input type="password" name="password" id="password" class="rectangle-3" placeholder="Password" required />
                <img class="image-4" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-1.png" />
              </div>

              <button type="submit" class="overlap-4">
                <div class="rectangle-4"></div>
                <div class="text-wrapper-5">LOG IN</div>
              </button>
              <a href="https://www.facebook.com/" target="_blank">
                <div class="overlap-5" style="cursor: pointer;">
                  <div class="rectangle-5"></div>
                  <div class="text-wrapper-6">Facebook</div>
                </div>
              </a>
              
              <a href="https://www.google.com/" target="_blank">
                <div class="overlap-6" style="cursor: pointer;">
                  <div class="rectangle-5"></div>
                  <div class="text-wrapper-7">Google</div>
                </div>
              </a>
              
              <div class="text-wrapper-8">Log In</div>
              <div class="text-wrapper-9">Forgot Password</div>
             <p class="don-t-have-account">
                  <span class="span">Don't have account? </span>
             <a href="Sign.php"><span class="text-wrapper-10">Sign Up</span></a>
               </p>

            </form>
          </div>
          <img class="image-5" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-5-1.png" />
          <img class="image-6" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-4.png" />
          <img class="logo-2" src="https://c.animaapp.com/mabuwas1L7eP4e/img/logo-1.png" />
          <img class="mask-group-3" src="https://c.animaapp.com/mabuwas1L7eP4e/img/mask-group-2.png" />
        </div>
        <p class="help-centre-payment">
          Help Centre <br />payment Methods <br />order Tracking <br />free Shipping <br />return &amp;
          Refund&nbsp;&nbsp;<br />contact Us
        </p>
        <div class="overlap-7">
          <div class="group-2">
            <div class="flash-express-wrapper">
              <img
                class="flash-express"
                src="https://c.animaapp.com/mabuwas1L7eP4e/img/flash-express-malaysia-1634103999-removebg-preview-1.png"
              />
            </div>
            <div class="rectangle-6"></div>
            <div class="rectangle-7"></div>
            <div class="rectangle-8"></div>
            <div class="rectangle-9"></div>
            <div class="rectangle-10"></div>
            <div class="rectangle-11"></div>
            <div class="rectangle-12"></div>
          </div>
          <img class="ninjavan-svg" src="https://c.animaapp.com/mabuwas1L7eP4e/img/ninjavan-svg-1.png" />
          <img
            class="element-travel-logo"
            src="https://c.animaapp.com/mabuwas1L7eP4e/img/2go-travel-logo--2018--svg-1.png"
          />
          <img
            class="element-j-t-express"
            src="https://c.animaapp.com/mabuwas1L7eP4e/img/648px-j-t-express-logo-svg-removebg-preview-1.png"
          />
          <a href="https://www.gcash.com/" target="_blank">
            <img class="gcash-logo" src="https://c.animaapp.com/mabuwas1L7eP4e/img/gcash-logo-500x281-1.png" />
          </a>
          
          
          <img class="image-7" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-5.png" />
          <img class="image-8" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-6.png" />
          <img class="image-9" src="https://c.animaapp.com/mabuwas1L7eP4e/img/image-7.png" />
        </div>
        <div class="text-wrapper-11">LOGISTICS</div>
        <div class="text-wrapper-12">PAYMENT METHODS</div>
        <div class="text-wrapper-13">CUSTOMER SERVICE</div>
        <div class="text-wrapper-14">ABOUT US</div>
        <p class="text-wrapper-15">
          ORPHIC is an eCommerce platform based in the Philippines, designed to serve the growing community of PC
          builders, gamers, and tech enthusiasts. It empowers users to build their own custom PCs with confidence by
          offering essential tools like part selection, compatibility checks, and curated templates. ORPHIC aims to
          become the go-to destination for reliable, beginner-friendly PC building solutions that combine both function
          and convenience.
        </p>
      </div>
    </div>
  </body>
</html>
