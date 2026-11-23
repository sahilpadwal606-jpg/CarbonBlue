<?php
// Start session at the beginning
session_start();
include 'connect.php'; 

function getProducts($conn, $limit = 6, $offset = 0) {
    $sql = "SELECT * FROM products LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);
    
    $products = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Get featured products (first 6)
$featuredProducts = getProducts($conn, 6, 0);

// Get new arrivals (next 6)
$newArrivals = getProducts($conn, 6, 6);
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
                    <li><a class="active" href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
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
          
        <section id="hero">
            <h4>Join-The-Fun</h4>
            <h2>Super Value Deals</h2>
            <h1>On All Toys and Books</h1> 
            <p>Unlock your potential with our top-notch educational resources - Now up to 25% off!</p>
            <button onclick="window.location.href='shop.php';">Shop Now</button>
        </section>
        
        <form action="cart.php" method="POST">
            <input type="hidden" name="id" value="id">
        </form>

        <section id="feature"> 
            <div class="fe-box">
                <div class="feature-item">
                    <img src="images/fastdelivery.png" alt="Fast Delivery Icon">
                    <h3>Lightning-Fast Delivery</h3>
                    <p>Get your products delivered in record time! We pride ourselves on swift service to keep you moving forward without any delay.</p>
                </div>
                <div class="feature-item">
                    <img src="images/bestquality.png" alt="Best Quality Icon">
                    <h3>Top-Notch Quality</h3>
                    <p>We offer the finest products crafted with precision and care. Trust in our commitment to excellence for unparalleled quality.</p>
                </div>
                <div class="feature-item">
                    <img src="images/freeshipping.png" alt="Free Shipping Icon">
                    <h3>Complimentary Shipping</h3>
                    <p>Enjoy hassle-free shopping with our free shipping on all orders. Your satisfaction is our priority from order to doorstep.</p>
                </div>
            </div>
        </section>

        <div class="features-product">
            <div>
                <section id="product1" class="product1">
                    <h2>Featured Products</h2>
                    <p>Fun and Learning: Fresh Picks for Young Minds</p>
                </div>
                <div class="pro-container">
                    <?php 
                    // Display featured products
                    if (!empty($featuredProducts)) {
                        foreach ($featuredProducts as $product) {
                            echo '<div class="pro" onclick="window.location.href=\'sproduct.php?name=' . urlencode($product['product_name']) . '&price=' . $product['price'] . '&img=' . urlencode($product['image_path']) . '\';">';
                            echo '<img src="' . $product['image_path'] . '" alt="' . $product['product_name'] . '">';
                            echo '<div class="product-details">';
                            echo '<span>' . $product['brand'] . '</span>';
                            echo '<h5>' . $product['product_name'] . '</h5>';
                            echo '<div class="star">';
                            for ($i = 0; $i < $product['rating']; $i++) {
                                echo '<i class="fas fa-star"></i>';
                            }
                            echo '</div>';
                            echo '<h4>₹' . $product['price'] . '</h4>';
                            echo '</div>';
                            echo '<a href="#" class="add-to-cart" data-product-id="' . $product['id'] . '"><i class="fal fa-shopping-cart"></i></a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No featured products available.</p>';
                    }
                    ?>
                </div>
            </div>
            
            <section id="banner" class="section-m1">
                <div class="banner-content">
                    <h4>Our Services</h4>
                    <h2>Up to 25% Off - All Toys & Books</h2>
                    <button class="explore-btn">Explore More</button>
                </div>
            </section>
            
            <div class="features-product">
                <section id="product1" class="product1">
                    <h2>New Arrivals</h2>
                    <p>Fun and Learning: Fresh Picks for Young Minds</p>
                </div>
                <div class="features-product">
                    <div class="pro-container">
                        <?php 
                        // Display new arrival products
                        if (!empty($newArrivals)) {
                            foreach ($newArrivals as $product) {
                                echo '<div class="pro" onclick="window.location.href=\'sproduct.php?name=' . urlencode($product['product_name']) . '&price=' . $product['price'] . '&img=' . urlencode($product['image_path']) . '\';">';
                                echo '<img src="' . $product['image_path'] . '" alt="' . $product['product_name'] . '">';
                                echo '<div class="product-details">';
                                echo '<span>' . $product['brand'] . '</span>';
                                echo '<h5>' . $product['product_name'] . '</h5>';
                                echo '<div class="star">';
                                for ($i = 0; $i < $product['rating']; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }
                                echo '</div>';
                                echo '<h4>₹' . $product['price'] . '</h4>';
                                echo '</div>';
                                echo '<a href="#" class="add-to-cart" data-product-id="' . $product['id'] . '"><i class="fal fa-shopping-cart"></i></a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No new arrivals available.</p>';
                        }
                        ?>
                    </div>
                </div>
            
            <section id="sm-banner" class="section-p1">
                <div class="banner-box">
                    <h4>crazy deals</h4>
                    <h2>buy 1 get 1 free</h2>
                    <span>The best class toys is on sale at CarbonBlue</span>
                </div>
                <div class="banner-box1">
                    <h4>crazy deals</h4>
                    <h2>buy 1 get 1 free</h2>
                    <span>The best class toys is on sale at CarbonBlue</span>
                </div>
            </section>

            <section id="banner3">
                <div class="banner-box1">
                    <h2>SEASONAL SALE</h2>
                    <h3>Grammar Games CD -25% OFF</h3>
                </div>
                <div class="banner-box2">
                    <h2>SEASONAL SALE</h2>
                    <h3>Jolly Jingles book and CD -25% OFF</h3>
                </div>
                <div class="banner-box3">
                    <h2>SEASONAL SALE</h2>
                    <h3>Grammar 1 Workbooks -25% OFF</h3>
                </div>
            </section>
        
            <div class="divider"></div>

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
                        <p><strong>Phone:</strong> <a href="tel:+917947121273">+91 79-47121273</a></p>
                        <p><strong>Email:</strong> Carbon.blue@yahoo.com</p>
                        <p><strong>Hours:</strong> 10:00 - 20:00, Mon - Sat</p>
                    </div>
                    <div class="footer-section about">
                        <h3>About</h3>
                        <ul>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="#">Delivery Information</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-section account">
                        <h3>My Account</h3>
                        <ul>
                            <li><a href="#">Sign In</a></li>
                            <li><a href="cart.php">View Cart</a></li>
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
                </div>
                <div class="footer-copyright">
                    <p> &copy; <span id="displayYear"></span> All Rights Reserved By Vidyalankar Polytechnic Students </p>
                </div>
            </footer>
    
            <?php
            // Close the database connection
            $conn->close();
            ?>
    
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="script.js"></script> 
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelector("form").addEventListener("submit", function(event) {
                        console.log("Form is submitting...");
                    });
                
                    // Ensure form submits from inside modal
                    document.getElementById("exampleModal").addEventListener("shown.bs.modal", function() {
                        document.querySelector("form").setAttribute("action", "register.php");
                    });
                });
            </script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
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
                });
            </script>
        </body>
</html>