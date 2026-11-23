<?php
// Start the session to manage user login state
session_start();
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
        
        <title>CarbonBlue</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>

        <section id="header">
            <a href="#"> <img src="images/image-icon-removebg-preview.png" class="logo" alt="Logo"> </a>

            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a class="active" href="about.php">About</a></li>
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

        <section id="page-header" class="about-header">
        
            <h2>#KnowUs</h2>
           
            <p>Get To Know Us Better!</p>
           
        </section>

        <section id="about-head" class="section-p1">
            <img src="images/shopping.png" alt="">
            <div>
                <h2> Who We Are? </h2>
                <p>At CarbonBlue, nestled in the heart of Vile Parle West, we are dedicated to creating a magical shopping experience for children and their families.
                 We specialize in a delightful array of kids' products, ranging from educational toys that ignite creativity to an extensive collection of captivating books that inspire young minds.
                 Our mission is to bring joy, laughter, and a sense of wonder to every child's life. Whether you're seeking the perfect birthday gift or a new adventure in the pages of a book, 
                 CarbonBlue is your go-to destination for all things kids. Shop with us and let the magic of childhood come to life!</p>
            </div>
        </section>

        <section id="about-head2" class="section-p1">
            <div>
                <h2> Our Mission </h2>
                <p> At CarbonBlue, our mission is to bring joy, creativity, and a sense of wonder to every child's life. We believe in providing high-quality, imaginative products that inspire and delight children of all ages. Our commitment is to create a magical shopping experience that celebrates childhood and fosters a love of learning. </p>
            </div>
        </section>

        <section id="about-head2" class="section-p1">
            <div>
                <h2> Our Values </h2>
                <p> (Creativity: We believe in the power of imagination and creativity to shape young minds. Our products are designed to spark curiosity and inspire new adventures.<br>
                    Quality: We are committed to offering only the highest quality products that are safe, durable, and designed to stand the test of time.<br>
                    Customer Satisfaction: Our customers are at the heart of everything we do. We strive to provide an exceptional shopping experience with personalized service and attention to detail.<br>
                    Community: We are proud to be a part of the Vile Parle West community and are dedicated to supporting local initiatives and fostering a sense of belonging.)</p>
            </div>
        </section>

        <section id="about-head3" class="section-p1">
            <img src="images/ceo.png.jpg" alt="">
            <div>
                <h2> Our Story </h2>
                <p>Smitaa Shettyy is a distinguished leader in international education in India, bringing over 25 years of corporate experience. With key roles at Cambridge University Press and Oxford University Press, she has pioneered the establishment of international qualifications in Indian schools. Her expertise spans early childhood development, curriculum design, and strategic school consultation. Smitaa has successfully integrated Oxford and Cambridge qualifications into Indian classrooms, ensuring they meet global standards while catering to local needs. Her contributions to school affiliations, academic advisory, and operational efficiency have transformed numerous schools, making her a respected figure in the Indian education sector. Through her innovative work and leadership, Smitaa continues to shape the future of education, helping schools deliver high-quality, globally relevant education to students across India.</p>
            </div>
        </section>     

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
</body>
</html>

