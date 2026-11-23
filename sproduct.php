<?php
// Initialize database connection
$servername = "localhost"; 
$username = "root";  // Change these credentials as needed
$password = "";      // Change these credentials as needed
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize variables to store product information
$product = null;
$related_products = [];

// First check the products table
if ($product_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product['source_table'] = 'products';
    } else {
        // If not found in products, check items table
        $stmt = $conn->prepare("SELECT * FROM items WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product['source_table'] = 'items';
        }
    }
    $stmt->close();
}

// Fetch related products (6 random products from the same brand if available)
if ($product) {
    $brand = $product['brand'];
    
    // Try to get products from the same brand, with different ID than current product
    $source_table = $product['source_table'];
    $id_field = ($source_table == 'products') ? 'id' : 'product_id';
    
    $stmt = $conn->prepare("SELECT * FROM $source_table WHERE brand = ? AND $id_field != ? LIMIT 6");
    $stmt->bind_param("si", $brand, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $related_products[] = $row;
        }
    } else {
        // If no products from same brand, get random products
        $stmt = $conn->prepare("SELECT * FROM $source_table WHERE $id_field != ? ORDER BY RAND() LIMIT 6");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $related_products[] = $row;
        }
    }
    $stmt->close();
}

// Close connection
$conn->close();

// If no product found, redirect to shop page
if (!$product) {
    header("Location: shop.php");
    exit();
}

// Determine field names based on source table
if ($product['source_table'] == 'products') {
    $name_field = 'product_name';
    $price_field = 'price';
    $image_field = 'image_path';
    $id_field = 'id';
} else { // items table
    $name_field = 'name';
    $price_field = 'price';
    $image_field = 'image_path';
    $id_field = 'product_id';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="toys, children's toys, educational toys, toy store, kids' toys, gifts for kids, fun toys, action figures, dolls, board games" />
        <meta name="description" content="Shop a wide variety of high-quality toys for children of all ages. From educational toys to action figures and dolls, we have the perfect gift for every child!" />
        <meta name="author" content="CarbonBlue Store" />
        <link rel="shortcut icon" href="image-icon.png" type="image/png">
        
        <title>CarbonBlue - <?php echo htmlspecialchars($product[$name_field]); ?></title>
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
                </ul>
            </div>
        </section>
        <section id="prodetails" class="section-p1">
            <div class="single-pro-image">
                <img id="product-img" src="<?php echo htmlspecialchars($product[$image_field]); ?>" width="350" alt="<?php echo htmlspecialchars($product[$name_field]); ?>">
            </div>
            <div class="single-pro-details">
                <h6>Home / <span id="product-category">Books</span></h6>
                <form id="addToCartForm">
                    <h4 id="product-name"><?php echo htmlspecialchars($product[$name_field]); ?></h4>
                    <h2 id="product-price">₹<?php echo number_format($product[$price_field], 2); ?></h2>
                    <!-- Hidden fields for product information -->
                    <input type="hidden" name="product_id" id="product-id" value="<?php echo $product[$id_field]; ?>">
                    <input type="hidden" name="source_table" id="source-table" value="<?php echo $product['source_table']; ?>">
                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                    <button type="button" id="add-to-cart-btn">Add To Cart</button>
                    <h4>Product Details</h4>
                    <span id="product-description">
                        <?php echo htmlspecialchars($product[$name_field]); ?> by <?php echo htmlspecialchars($product['brand']); ?> is a fantastic educational resource, helping children to learn in a fun and interactive way.
                    </span>
                </form>
            </div>
        </section>
    
        <div class="features-product">
            <div>
                <section id="product1" class="product1">
                    <h2>Related Products</h2>
                </div>
                
                <div>
                    <section id="product1" class="product1">
                    <p>Fun and Learning: More Products You May Like</p>
                </div>
                <div class="pro-container">
                    <?php foreach ($related_products as $related): 
                        // Determine field names based on source table
                        if ($product['source_table'] == 'products') {
                            $rel_name_field = 'product_name';
                            $rel_price_field = 'price';
                            $rel_image_field = 'image_path';
                            $rel_id_field = 'id';
                        } else { // items table
                            $rel_name_field = 'name';
                            $rel_price_field = 'price';
                            $rel_image_field = 'image_path';
                            $rel_id_field = 'product_id';
                        }
                    ?>
                    <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $related[$rel_id_field]; ?>';">
                        <img src="<?php echo htmlspecialchars($related[$rel_image_field]); ?>" alt="<?php echo htmlspecialchars($related[$rel_name_field]); ?>">
                        <div class="product-details">
                            <span><?php echo htmlspecialchars($related['brand']); ?></span>
                            <h5><?php echo htmlspecialchars($related[$rel_name_field]); ?></h5>
                            <div class="star">
                                <?php 
                                $rating = isset($related['rating']) ? $related['rating'] : 4;
                                for ($i = 0; $i < $rating; $i++): 
                                ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <h4>₹<?php echo number_format($related[$rel_price_field], 2); ?></h4>
                        </div>
                        <a href="#"><i class="fal fa-shopping-cart"></i></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
                            
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            // Prevent negative quantity
            $('#quantity').on('input change', function() {
                if ($(this).val() < 1 || $(this).val() === '') {
                    $(this).val(1);
                }
            });
            
            // Add to cart button click handler
            $('#add-to-cart-btn').click(function() {
                const productId = $('#product-id').val();
                const sourceTable = $('#source-table').val();
                const quantity = $('#quantity').val();
                
                if(!productId) {
                    alert('Product ID is missing!');
                    return;
                }
                
                $.ajax({
                    url: 'add_to_cart.php',
                    type: 'POST',
                    data: { 
                        product_id: productId,
                        quantity: quantity,
                        source: sourceTable // Specify the source table
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert("Added to cart successfully!");
                            // Redirect to cart page
                            window.location.href = 'cart.php';
                        } else {
                            alert(response.message || 'Error adding to cart');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                        alert('Error occurred while adding to cart');
                    }
                });
            });
        });

        // Set the current year in footer
        document.getElementById('displayYear').textContent = new Date().getFullYear();
        </script>    
    </body>
</html>