<?php
session_start();
include 'connect.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with an error message
    echo "<script>
        alert('You must be logged in to view your cart.');
        window.location.href = 'index.php'; // Direct to login page instead of index
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Get all cart items for the user with product details in a single query
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

    // Prepare to store cart items with product details
    $cart_items = [];
    $total = 0;

    // Process each cart item
    while ($row = $cart_result->fetch_assoc()) {
        if ($row['name'] && $row['price']) { // Ensure the product exists in either table
            $item = [
                'cart_id' => $row['cart_id'],
                'product_id' => $row['product_id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'image' => $row['image'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity']
            ];
            
            // Add to cart items array
            $cart_items[] = $item;
            
            // Update total
            $total += $item['subtotal'];
        }
    }
} catch (Exception $e) {
    // Handle any database errors
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
    <title>Shopping Cart - CarbonBlue</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<section id="header">
            <a href="#"> <img src="images/image-icon-removebg-preview.png" class="logo" alt="Logo"> </a>
            
            <div>
                <ul id="navbar">
                    <li><a  href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a class="active" href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
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
    <h2>Shopping Cart</h2>
    <p>Review your items before checkout</p>
</section>

<section id="cart" class="section-p1">
    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any products to your cart yet.</p>
            <a href="shop.php" class="submit-button">Continue Shopping</a>
        </div>
    <?php else: ?>
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><a href="javascript:void(0);" class="remove-item" data-id="<?php echo $item['cart_id']; ?>"><i class="far fa-times-circle"></i></a></td>
                        <td><img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <div class="quantity-control">
                                <button class="qty-btn minus" data-id="<?php echo $item['cart_id']; ?>">-</button>
                                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="update-quantity" data-id="<?php echo $item['cart_id']; ?>">
                                <button class="qty-btn plus" data-id="<?php echo $item['cart_id']; ?>">+</button>
                            </div>
                        </td>
                        <td class="subtotal" data-id="<?php echo $item['cart_id']; ?>">₹<?php echo number_format($item['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php if (!empty($cart_items)): ?>
    <section id="cart-add" class="section-p1">
        <!-- <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" id="coupon-code" placeholder="Enter Your Coupon">
                <button id="apply-coupon" class="submit-button">Apply</button>
            </div>
        </div> -->
        <div id="Subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td id="cart-total">₹<?php echo number_format($total, 2); ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>₹150.00</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong id="final-total">₹<?php echo number_format($total + 150, 2); ?></strong></td>
                </tr>
            </table>
            <button id="checkout-btn" class="submit-button">Proceed to Checkout</button>
        </div>
    </section>
<?php endif; ?>

<!-- Status message div -->
<div id="status-message" class="status-message"></div>

<script>
$(document).ready(function() {
    // Update cart quantity
    $('.update-quantity').on('change', function() {
        updateQuantity($(this));
    });

    // Quantity buttons functionality
    $('.qty-btn.plus').on('click', function() {
        var input = $(this).siblings('.update-quantity');
        input.val(parseInt(input.val()) + 1);
        updateQuantity(input);
    });

    $('.qty-btn.minus').on('click', function() {
        var input = $(this).siblings('.update-quantity');
        var value = parseInt(input.val());
        if (value > 1) {
            input.val(value - 1);
            updateQuantity(input);
        }
    });

    function updateQuantity(input) {
        var cartId = input.data('id');
        var newQuantity = input.val();
        
        if (newQuantity < 1) {
            newQuantity = 1;
            input.val(1);
        }
        
        $.ajax({
            url: 'update_cart.php',
            type: 'POST',
            dataType: 'json',
            data: { cart_id: cartId, quantity: newQuantity },
            success: function(response) {
                if (response.status === 'success') {
                    // Update subtotal for this item
                    $('.subtotal[data-id="' + cartId + '"]').text('₹' + response.item_subtotal.toFixed(2));
                    
                    // Update cart total
                    $('#cart-total').text('₹' + response.cart_subtotal.toFixed(2));
                    $('#final-total').text('₹' + (response.cart_subtotal + 150).toFixed(2));
                    
                    // Show success message
                    showMessage('Cart updated successfully', 'success');
                } else {
                    showMessage('Error updating cart: ' + response.message, 'error');
                }
            },
            error: function() {
                showMessage('An error occurred while updating the cart', 'error');
            }
        });
    }

    // Remove item from cart
    $('.remove-item').on('click', function() {
        var cartId = $(this).data('id');
        
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            $.ajax({
                url: 'remove_from_cart.php',
                type: 'POST',
                dataType: 'json',
                data: { cart_id: cartId },
                success: function(response) {
                    if (response.status === 'success') {
                        // Remove the row from the table
                        $('tr').has('.remove-item[data-id="' + cartId + '"]').remove();
                        
                        // Update cart total
                        $('#cart-total').text('₹' + response.cart_subtotal.toFixed(2));
                        $('#final-total').text('₹' + (response.cart_subtotal + 150).toFixed(2));
                        
                        // If cart is empty, refresh the page to show empty cart message
                        if (response.cart_count === 0) {
                            location.reload();
                        }
                        
                        showMessage('Item removed from cart', 'success');
                    } else {
                        showMessage('Error removing item: ' + response.message, 'error');
                    }
                },
                error: function() {
                    showMessage('An error occurred while removing the item', 'error');
                }
            });
        }
    });

    // Checkout button
    $('#checkout-btn').on('click', function() {
        window.location.href = 'checkout.php';
    });

    // Apply coupon (placeholder functionality)
    $('#apply-coupon').on('click', function() {
        var couponCode = $('#coupon-code').val().trim();
        if (couponCode) {
            // This is just a placeholder - implement actual coupon logic
            showMessage('Coupon code applied successfully', 'success');
        } else {
            showMessage('Please enter a coupon code', 'error');
        }
    });

    // Function to show status messages
    function showMessage(message, type) {
        var statusDiv = $('#status-message');
        statusDiv.text(message).attr('class', 'status-message ' + type).fadeIn();
        
        setTimeout(function() {
            statusDiv.fadeOut();
        }, 3000);
    }
});
</script>

</body>
</html>