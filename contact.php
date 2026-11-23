<?php

session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="image-icon.png" type="image/png">
        
        <title>CarbonBlue</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            console.log("Form is submitting...");
        });
    </script>

    <body>
            <section id="header">
            <a href="#"> <img src="images/image-icon-removebg-preview.png" class="logo" alt="Logo"> </a>
            
            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a class="active" href="contact.php">Contact</a></li>
                    <li><a href="cart.php"><i class=" far fa-shopping-bag"></i></a></li>
                    <li id="profileSection">
                        <?php if (isset($_SESSION["user_name"])): ?>
                            <a href="profile.php" id="profileLink">
                                <i class="fas fa-user"></i> 
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Login
                            </button>
                        <?php endif; ?>
                    </li>
                    
                </ul>
            </div>
        </section>

           <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 100%; max-width: 1000px; margin: auto;">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Login System HTML -->
                  
                  <div id="popup" class="popup-container">
                    <div class="popup">
                      
                      <div class="login-container" id="container">
                        <div class="form-container sign-up">
                            <form id="registerForm" action="register.php" method="POST">
                                <h1>Create Account</h1>
                                <span>use your email for registration</span>
                                <input type="text" name="name" placeholder="Name" required/>
                                <input type="text" name="phone" placeholder="Phone Number" required/>
                                <input type="email" name="email" placeholder="Email" required/>
                                <input type="password" name="password" placeholder="Password" required/>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required/>
                                <button type="submit">Sign Up</button>
                            </form>
                            
                        </div>
                        <div class="form-container sign-in">
                            <form id="loginForm" action="login.php" method="POST">
                                <h1>Sign In</h1>
                                <span>Use your email and password</span>
                                <input type="email" name="email" placeholder="Email" required/>
                                <input type="password" name="password" placeholder="Password" required/>
                                <a href="#">Forgot Your Password?</a>
                                <button type="submit">Sign In</button>
                            </form>
                            
                        </div>
                        <div class="toggle-container">
                          <div class="toggle">
                            <div class="toggle-panel toggle-left">
                              <h1>Hello, Friend!</h1>
                              <p>By creating an account or logging in, you agree to Carbon Blue's Conditions of Use and Privacy Policy.</p>
                              <button class="hidden" id="login">Sign In</button>
                            </div>
                            <div class="toggle-panel toggle-right">
                              <h1>Welcome Back!</h1>
                              <p>Ready to continue the fun? Sign in with your details here</p>
                              <button class="hidden" id="register">Sign Up</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>                 

        <section id="page-header" class="about-header">
        
            <h2> #let's_Talk </h2>
           
            <p> Leave A Message, We Would Love To Hear From You! </p>
           
        </section>

       <section id="contact-details" class="section-p1">
        <div class="details">
            <span>Get In Touch</span>
            <h2>Visit one of our agency locations or contact us today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fal fa-map"> </i>
                    <p>22, Seva Sadan, Vile Parle West,<br>
                        Mumbai - 400056 (Near Macdonald,<br> Opposite Shanti Store)</p>
                </li>

                <li>
                    <i class="fal fa-envelope"> </i>
                    <p>Carbon.blue@yahoo.com</p>
                </li>

                <li>
                    <i class="fal fa-phone-alt"> </i>
                    <p>+91 79-47121273</p>
                </li>

                <li>
                    <i class="fal fa-clock"> </i>
                    <p> 10:00 - 20:00, Mon - Sat </p>
                </li>
            </div>
        </div>
         
        <div class="map">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7540.56808965942!2d72.84103404999999!3d19.09519105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c9b06862d159%3A0x6c281f6cf8a139d9!2sLIC%20Colony%2C%20Suresh%20Colony%2C%20Vile%20Parle%20West%2C%20Mumbai%2C%20Maharashtra%20400047!5e0!3m2!1sen!2sin!4v1737981930048!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

       </section>

       <section id="from-details">
        <form action="sendmail.php" method="POST">
            <span> Leave A Message </span>
            <h2> We Would Love To Hear From You </h2>
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="email" placeholder="E-mail" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
            <button type="submit" class="submit-button">Submit</button>
        </form>
       </section>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Footer Example</title>
</head>

<footer class="section-p1">
    <div class="footer-container">
        <div class="footer-section address">
            <h3>Address</h3>
            <p>22, Seva Sadan, Vile Parle West,<br>
            Mumbai - 400056 (Near Macdonald,<br> Opposite Shanti Store)</p>
        </div>
        <div class="footer-section info">
            <h3>Info</h3>
            <p>At CarbonBlue, we believe that every child deserves a magical shopping experience filled with joy, laughter, and excitement. Our mission is to bring you the best products that inspire creativity, spark imagination, and make every day a new adventure.</p>
        </div>
        <div class="footer-section contact">
            <h3>Contact</h3>
            <p><strong>Phone:</strong> +91 79-47121273</p>
            <p><strong>Email:</strong> Carbon.blue@yahoo.com</p>
            <p><strong>Hours:</strong> 10:00 - 20:00, Mon - Sat</p>
        </div>
        <div class="footer-section about">
            <h3>About</h3>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Delivery Information</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-section account">
            <h3>My Account</h3>
            <ul>
                <li><a href="#">Sign In</a></li>
                <li><a href="#">View Cart</a></li>
                <li><a href="#">My Wishlist</a></li>
                <li><a href="#">Track My Order</a></li>
                <li><a href="#">Help</a></li>
            </ul>
        </div>
        <div class="footer-section bank-details ">
            <h3> Bank Details </h3>
            <div>
                Here should be the bank details
            </div>
            <p> Secured Payment Gateways </p>
            </div>
    <div class="footer-copyright">
        <p> &copy; <span id="displayYear"></span> All Rights Reserved By Vidyalankar Polytechnic Students </p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function displayCurrentYear() {
            var year = new Date().getFullYear();
            var yearElement = document.getElementById("displayYear");
            if (yearElement) {
                yearElement.innerText = year;
            }
        }
        displayCurrentYear();
    });
    </script>

    <!-- Bootstrap 5 bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384‑...sha‑hash‑here..." crossorigin="anonymous"></script>

<!-- Optional: jQuery (only if something in script.js needs it) -->
<script src="https://code.jquery.com/jquery‑3.6.0.min.js"
        integrity="sha384‑...sha‑hash‑here..." crossorigin="anonymous"></script>

<!-- Your site‑specific logic -->
<script src="script.js"></script>

</body>
</html> 

