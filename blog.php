<?php
// Start the session to manage user login state if needed
session_start();
include 'connect.php'; // Include your database connection file

// Initialize logging function
function logActivity($action, $details = '', $user = 'Unknown') {
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    // Create log entry
    $logEntry = "[$timestamp] IP: $ip | User: $user | Action: $action | $details | $userAgent\n";
    
    // Write to log file
    $logFile = 'logs/blog_activity.log';
    
    // Create logs directory if it doesn't exist
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    
    // Append to log file
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Handle blog submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_blog'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $blog_content = mysqli_real_escape_string($conn, $_POST['blog_content']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    
    // Insert blog into database
    $sql = "INSERT INTO user_blogs (name, email, content, rating, created_at) 
            VALUES ('$name', '$email', '$blog_content', '$rating', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        // Log successful blog submission
        logActivity('Blog Submission', "Name: $name, Rating: $rating", $email);
        
        // Store success message in session
        $_SESSION['success_message'] = "Your blog has been published successfully!";
        
        // Redirect to prevent form resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Log error
        logActivity('Blog Submission Error', "SQL Error: " . $conn->error, $email);
        
        // Store error message in session
        $_SESSION['error_message'] = "Error: " . $conn->error;
        
        // Redirect to prevent form resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Check for messages in session and then clear them
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear the messages from the session
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Fetch blogs
$blogs_sql = "SELECT * FROM user_blogs ORDER BY created_at DESC";
$blogs_result = $conn->query($blogs_sql);
$blogs = [];

if ($blogs_result && $blogs_result->num_rows > 0) {
    while ($row = $blogs_result->fetch_assoc()) {
        $blogs[] = $row;
    }
    
    // Log blog view activity
    logActivity('Blog View', "Displayed " . count($blogs) . " blogs", 
        isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : 'Guest');
} else {
    // Log that no blogs were found
    logActivity('Blog View', "No blogs found in database", 
        isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : 'Guest');
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="image-icon.png" type="image/png">
    <title>CarbonBlue</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="style.css">
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

        <section id="page-header" class="blog-header">
        
            <h2>#readmore</h2>
           
            <p>Read all case studies about our products!</p>
           
        </section>
   
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #beige;
        }
        
        /* Main content container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        /* Blog container */
        .blogs-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        @media (max-width: 992px) {
            .blogs-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Left side - Blog posts */
        .blogs-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .blogs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background-color: #088178;
            color: white;
        }
        
        .blogs-header h2 {
            margin: 0;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .blogs-count {
            background-color: white;
            color: #088178;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .toggle-btn {
            background-color: white;
            color: #088178;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .toggle-btn:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
        }
        
        .toggle-btn i {
            margin-right: 5px;
        }
        
        .blogs-list {
            padding: 25px;
            max-height: 800px;
            overflow-y: auto;
        }
        
        .blog-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 25px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid #088178;
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .blog-card-inner {
            padding: 20px;
        }
        
        .blog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .blogger-info {
            display: flex;
            align-items: center;
        }
        
        .blogger-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #088178;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            font-size: 18px;
        }
        
        .blogger-name-date {
            display: flex;
            flex-direction: column;
        }
        
        .blogger-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        
        .blog-date {
            font-size: 14px;
            color: #888;
        }
        
        .blog-rating {
            color: #ff9800;
            font-size: 16px;
        }
        
        .blog-content {
            line-height: 1.6;
            color: #555;
            font-size: 16px;
            margin-top: 15px;
        }
        
        /* Right side - Write a blog */
        .write-blog-section {
            background-color: white;
            border-radius: 10px;
            padding: 250px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
            padding-left: 20px;
            padding-bottom: 20px;
            padding-top: 20px;
        }
        
        .write-blog-section h3 {
            color: #088178;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f1f1;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-control {
            width: 200%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #088178;
            outline: none;
        }
        
        .form-control::placeholder {
            color: #aaa;
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        
        .rating-stars input {
            display: none;
        }
        
        .rating-stars label {
            cursor: pointer;
            font-size: 25px;
            color: #ddd;
            padding: 0 3px;
            transition: color 0.2s ease;
        }
        
        .rating-stars label:hover,
        .rating-stars label:hover ~ label,
        .rating-stars input:checked ~ label {
            color: #ff9800;
        }
        
        .submit-btn {
            display: block;
            width: 100%;
            background-color: #088178;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background-color: #066963;
            transform: translateY(-2px);
        }
        
        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            animation: fadeIn 0.5s;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Utility */
        .hidden {
            display: none;
        }
        
        /* Special feature: Tags */
        .blog-tags {
            display: flex;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        
        .blog-tag {
            background-color: #e9f7f7;
            color: #088178;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        
        /* Blog stats section */
        .blog-stats {
            margin-top: 40px;
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stats-header {
            color: #088178;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f1f1;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .stat-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #088178;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #555;
            font-size: 14px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .blog-top {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="blogs-container">
            <!-- Left side - Blog posts -->
            <div class="blogs-section">
                <div class="blogs-header">
                    <h2>
                        Latest Blogs 
                        <span class="blogs-count"><?php echo count($blogs); ?></span>
                    </h2>
                    <button class="toggle-btn" onclick="toggleBlogs()">
                        <i class="fas fa-eye"></i> <span id="toggle-text">Hide Blogs</span>
                    </button>
                </div>
                
                <div id="blogs-content" class="blogs-list">
                    <?php foreach($blogs as $blog): ?>
                        <div class="blog-card">
                            <div class="blog-card-inner">
                                <div class="blog-header">
                                    <div class="blogger-info">
                                        <div class="blogger-avatar">
                                            <?php echo substr($blog['name'], 0, 1); ?>
                                        </div>
                                        <div class="blogger-name-date">
                                            <span class="blogger-name"><?php echo $blog['name']; ?></span>
                                            <span class="blog-date"><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $blog['rating']): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="blog-content">
                                    <?php echo $blog['content']; ?>
                                </div>
                                <div class="blog-tags">
                                    <span class="blog-tag">Customer Experience</span>
                                    <span class="blog-tag">Feedback</span>
                                    <?php if($blog['rating'] >= 4): ?>
                                        <span class="blog-tag">Top Rated</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Right side - Write a blog -->
            <div class="write-blog-section">
                <h3>Write a Blog</h3>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Rating</label>
                        <div class="rating-stars">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5"><i class="fas fa-star"></i></label>
                            
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="blog_content">Your Experience With CarbonBlue</label>
                        <textarea class="form-control" id="blog_content" name="blog_content" placeholder="Share how you feel about our website, products, service, and overall experience..." required></textarea>
                    </div>
                    
                    <button type="submit" name="submit_blog" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Publish Blog
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Blog Stats Section -->
        <div class="blog-stats">
            <h3 class="stats-header">Community Stats</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($blogs); ?></div>
                    <div class="stat-label">Published Blogs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">
                        <?php
                            $total_rating = 0;
                            foreach($blogs as $blog) {
                                $total_rating += $blog['rating'];
                            }
                            $avg_rating = count($blogs) > 0 ? round($total_rating / count($blogs), 1) : 0;
                            echo $avg_rating;
                        ?>
                    </div>
                    <div class="stat-label">Average Rating</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">
                        <?php
                            $high_ratings = 0;
                            foreach($blogs as $blog) {
                                if($blog['rating'] >= 4) $high_ratings++;
                            }
                            echo $high_ratings;
                        ?>
                    </div>
                    <div class="stat-label">High Ratings (4-5)</div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Display current year in footer
            function displayCurrentYear() {
                var year = new Date().getFullYear();
                var yearElement = document.getElementById("displayYear");
                if (yearElement) {
                    yearElement.innerText = year;
                }
            }
            displayCurrentYear();
        });
        
        // Toggle blogs visibility
        function toggleBlogs() {
            var blogsContent = document.getElementById('blogs-content');
            var toggleText = document.getElementById('toggle-text');
            
            if (blogsContent.classList.contains('hidden')) {
                blogsContent.classList.remove('hidden');
                toggleText.textContent = 'Hide Blogs';
            } else {
                blogsContent.classList.add('hidden');
                toggleText.textContent = 'Show Blogs';
            }
        }
    </script>
</body>
</html>