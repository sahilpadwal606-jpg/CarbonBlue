<?php
session_start();
include 'connect.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('You must be logged in to checkout.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Initialize variables
$order_success = false;
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["place_order"])) {
    // Get cart total
    $total_query = "
        SELECT 
            SUM(COALESCE(p.price, i.price) * c.quantity) as total
        FROM 
            cart c
        LEFT JOIN 
            products p ON c.product_id = p.id
        LEFT JOIN 
            items i ON c.product_id = i.product_id
        WHERE 
            c.user_id = ?
    ";
    
    $stmt = $conn->prepare($total_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_price = $row['total'] + 150; // Adding shipping cost
    
    // Get shipping and payment details from form
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    
    // Create the order
    $conn->begin_transaction();
    
    try {
        // Insert into orders table
        $order_sql = "INSERT INTO orders (user_id, total_price, shipping_address, payment_method, order_date) 
                      VALUES (?, ?, ?, ?, NOW())";
        $order_stmt = $conn->prepare($order_sql);
        $shipping_address = "$address, $city, $state - $zip";
        $order_stmt->bind_param("idss", $user_id, $total_price, $shipping_address, $payment_method);
        $order_stmt->execute();
        $order_id = $conn->insert_id;
        
        // Get all cart items
        $cart_query = "SELECT c.product_id, c.quantity, COALESCE(p.price, i.price) as price 
                       FROM cart c 
                       LEFT JOIN products p ON c.product_id = p.id 
                       LEFT JOIN items i ON c.product_id = i.product_id
                       WHERE c.user_id = ?";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param("i", $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        
        // Insert order items
        while ($cart_item = $cart_result->fetch_assoc()) {
            $order_items_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                VALUES (?, ?, ?, ?)";
            $items_stmt = $conn->prepare($order_items_sql);
            $items_stmt->bind_param("iiid", $order_id, $cart_item['product_id'], $cart_item['quantity'], $cart_item['price']);
            $items_stmt->execute();
        }
        
        // Clear the cart
        $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
        $clear_stmt = $conn->prepare($clear_cart_sql);
        $clear_stmt->bind_param("i", $user_id);
        $clear_stmt->execute();
        
        // Commit transaction
        $conn->commit();
        $order_success = true;
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error_message = "Error placing order: " . $e->getMessage();
    }
}

// Get cart items for display
try {
    $cart_query = "
        SELECT 
            c.id as cart_id, 
            c.product_id,
            c.quantity,
            COALESCE(p.product_name, i.name) as name,
            COALESCE(p.price, i.price) as price,
            COALESCE(p.image_path, i.image_path) as image
        FROM 
            cart c
        LEFT JOIN 
            products p ON c.product_id = p.id
        LEFT JOIN 
            items i ON c.product_id = i.product_id
        WHERE 
            c.user_id = ".$user_id."
    ";
    
    $cart_result = $conn->query($cart_query);
    $cart_items = [];
    $total = 0;
    
    while ($row = $cart_result->fetch_assoc()) {
        if ($row['name'] && $row['price']) {
            $item = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity']
            ];
            
            $cart_items[] = $item;
            $total += $item['subtotal'];
        }
    }
} catch (Exception $e) {
    echo "<div class='error-message'>Error loading cart: " . $e->getMessage() . "</div>";
    $cart_items = [];
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CarbonBlue</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<section id="header">
            <a href="#"> <img src="images/image-icon-removebg-preview.png" class="logo" alt="Logo"> </a>
            
            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a class="active" href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
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

<section id="page-header">
    <h2>Checkout</h2>
    <p>Complete your purchase</p>
</section>

<?php if ($order_success): ?>
    <section class="section-p1">
        <div class="success-message">
            <h2><i class="fas fa-check-circle"></i> Order Placed Successfully!</h2>
            <p>Thank you for your purchase. Your order has been received.</p>
            <p>Order #<?php echo $order_id; ?></p>
            <a href="shop.php" class="submit-button">Continue Shopping</a>
        </div>
    </section>
<?php elseif (empty($cart_items)): ?>
    <section class="section-p1">
        <div class="empty-cart">
            <h2>Your cart is empty</h2>
            <p>You cannot proceed to checkout with an empty cart.</p>
            <a href="shop.php" class="submit-button">Go Shopping</a>
        </div>
    </section>
<?php else: ?>
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <section id="checkout" class="section-p1">
        <div class="checkout-container">
            <div class="checkout-form">
                <h3>Shipping Information</h3>
                <form id="order-form" method="POST" action="checkout.php">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        <div class="form-group">
                            <label for="zip">ZIP Code</label>
                            <input type="text" id="zip" name="zip" required>
                        </div>
                    </div>
                    
                    <h3>Payment Method</h3>
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="cod" name="payment_method" value="cod" checked>
                            <label for="cod">Cash on Delivery</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="card" name="payment_method" value="card">
                            <label for="card">Credit/Debit Card</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="upi" name="payment_method" value="upi">
                            <label for="upi">UPI</label>
                        </div>
                    </div>
                    
                    <!-- Card payment details (conditionally shown) -->
                    <div id="card-details" class="payment-details" style="display: none;">
                        <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <input type="text" id="card-number" name="card_number">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiry">Expiry Date</label>
                                <input type="text" id="expiry" name="expiry" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv">
                            </div>
                        </div>
                    </div>
                    
                    <!-- UPI payment details (conditionally shown) -->
                    <div id="upi-details" class="payment-details" style="display: none;">
                        <div class="form-group">
                            <label for="upi-id">UPI ID</label>
                            <input type="text" id="upi-id" name="upi_id" placeholder="example@ybl">
                        </div>
                    </div>
                    
                    <button type="submit" name="place_order" class="submit-button">Place Order</button>
                </form>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                <table class="order-summary-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td>x<?php echo $item['quantity']; ?></td>
                                <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Subtotal</td>
                            <td>₹<?php echo number_format($total, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Shipping</td>
                            <td>₹150.00</td>
                        </tr>
                        <tr class="grand-total">
                            <td colspan="2"><strong>Total</strong></td>
                            <td><strong>₹<?php echo number_format($total + 150, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
$(document).ready(function() {
    // Show/hide payment details based on selection
    $('input[name="payment_method"]').change(function() {
        $('.payment-details').hide();
        
        if ($(this).val() === 'card') {
            $('#card-details').show();
        } else if ($(this).val() === 'upi') {
            $('#upi-details').show();
        }
    });
    
    // Form validation
    $('#order-form').submit(function(event) {
        var paymentMethod = $('input[name="payment_method"]:checked').val();
        
        if (paymentMethod === 'card') {
            var cardNumber = $('#card-number').val();
            var expiry = $('#expiry').val();
            var cvv = $('#cvv').val();
            
            if (!cardNumber || !expiry || !cvv) {
                alert('Please fill in all card details');
                event.preventDefault();
                return false;
            }
        } else if (paymentMethod === 'upi') {
            var upiId = $('#upi-id').val();
            
            if (!upiId) {
                alert('Please enter your UPI ID');
                event.preventDefault();
                return false;
            }
        }
        
        return true;
    });
});
</script>

</body>
</html>