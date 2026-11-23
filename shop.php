<?php
session_start(); 
include 'connect.php'; 

// Query to get all products from the items table
$sql = "SELECT product_id, name, brand, price, price_text, image_path, rating FROM items";
$result = $conn->query($sql);

// Store products in array
$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="toys, children's toys, educational toys, toy store, kids' toys, gifts for kids, fun toys, action figures, dolls, board games" />
        <meta name="description" content="Shop a wide variety of high-quality toys for children of all ages. From educational toys to action figures and dolls, we have the perfect gift for every child!" />
        <meta name="author" content="CarbonBlue Store" />
        <link rel="shortcut icon" href="image-icon.png" type="image/png">
        <title>CarbonBlue - Shop</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <section id="header">
            <a href="#"> <img src="images/image-icon-removebg-preview.png" class="logo" alt="Logo"> </a>
            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a class="active" href="shop.php">Shop</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
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

        <!-- Login Modal -->
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

        <section id="page-header">
            <h2>#Funwithtoys</h2>
            <p>Unlock your potential with our top-notch educational resources - Now up to 25% off!</p>
        </section>

        <section id="product1" class="section-p1">
            <div class="pro-container">
                <?php
                // Display products
                foreach ($products as $product) {
                    // Generate star rating HTML
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $product['rating']) {
                            $stars .= '<i class="fas fa-star"></i>';
                        } else {
                            $stars .= '<i class="far fa-star"></i>';
                        }
                    }
                    
                    // Display price (use price_text if available, otherwise format price)
                    $price_display = !empty($product['price_text']) ? $product['price_text'] : '₹' . $product['price'];
                    
                    // Output product HTML
                    echo '<div class="pro" onclick="window.location.href=\'sproduct.php?id=' . $product['product_id'] . '&name=' . urlencode($product['name']) . '&price=' . $product['price'] . '&img=' . urlencode($product['image_path']) . '\';">';
                    echo '<img src="' . htmlspecialchars($product['image_path']) . '" alt="' . htmlspecialchars($product['name']) . '">';
                    echo '<div class="des">';
                    echo '<span>' . htmlspecialchars($product['brand']) . '</span>';
                    echo '<h5>' . htmlspecialchars($product['name']) . '</h5>';
                    echo '<div class="star">' . $stars . '</div>';
                    echo '<h4>' . htmlspecialchars($price_display) . '</h4>';
                    echo '</div>';
                    // echo '<a href="#" class="add-to-cart" data-product-id="' . $product['product_id'] . '"><i class="fal fa-shopping-cart cart"></i></a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>


        

        <footer class="section-p1">
            <div class="footer-container">
                <div class="footer-section address">
                    <h3>Address</h3>
                    <p>22, Seva Sadan, Vile Parle West,<br>
                    Mumbai - 400056 (Near Mcdonald,<br> Opposite Shanti Store)</p>
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
                <div class="footer-section bank-details">
                    <h3>Bank Details</h3>
                    <div>
                        Here should be the bank details
                    </div>
                    <p>Secured Payment Gateways</p>
                </div>
            </div>
            <div class="footer-copyright">
                <p>&copy; <span id="displayYear"></span> All Rights Reserved By Vidyalankar Polytechnic Students</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js"></script>
        <script>
            // Get current year for copyright
            document.getElementById('displayYear').textContent = new Date().getFullYear();
            
            // Add to cart functionality
            $(document).ready(function () {
                $(".add-to-cart").click(function (e) {
                    e.preventDefault(); // Prevent the default action
                    e.stopPropagation(); // Stop event bubbling
                    
                    var productId = $(this).data("product-id");

                    $.ajax({
                        url: "cart.php",
                        method: "POST",
                        data: { action: "add", id: productId },
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                alert("Item added to cart!");
                                $("#cart-count").text(response.cart_count); // Update cart count
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                });
                
                // Toggle between login and signup forms
                const container = document.getElementById('container');
                const registerBtn = document.getElementById('register');
                const loginBtn = document.getElementById('login');

                registerBtn.addEventListener('click', () => {
                    container.classList.add("active");
                });

                loginBtn.addEventListener('click', () => {
                    container.classList.remove("active");
                });
            });
        </script>
    </body>
</html>