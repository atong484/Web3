<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CarHub</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
        body{
            min-height:100vh;
            background:#0a0a12;
            position:relative;overflow-x:hidden;
            color:#fff;
        }
        #particles{
            position:fixed;top:0;left:0;width:100%;height:100%;z-index:1;
        }
        
        .user-info {
            position:relative;z-index:2;
            background:rgba(30,30,50,0.7);
            backdrop-filter:blur(15px);
            padding:10px 25px;
            text-align:center;
            color:rgba(255,255,255,0.8);
            font-size:14px;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }
        .user-info a {
            color:#00ffe7;
            text-decoration:none;
            margin-left:10px;
        }
        .user-info a:hover {
            text-decoration:underline;
        }

        .navbar {
            position:relative;z-index:2;
            background:rgba(30,30,50,0.7);
            backdrop-filter:blur(15px);
            padding: 18px 25px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            border-bottom:1px solid rgba(255,255,255,0.1);
            box-shadow:0 4px 20px rgba(0,0,0,0.4);
        }
        .logo {
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            font-size: 24px;
            font-weight: 700;
        }
        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }
        .nav-links a {
            color:rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 16px;
            font-weight:500;
            transition:all 0.3s;
        }
        .nav-links a:hover {
            color:#00ffe7;
            transform:scale(1.08);
        }


        .container {
            position:relative;z-index:2;
            width:90%;
            max-width:1200px;
            margin:40px auto;
            padding:20px;
        }
        .title {
            font-size:32px;font-weight:700;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            margin-bottom:30px;
            text-align:center;
        }
        .row {
            display:flex;
            flex-wrap:wrap;
            gap:30px;
            margin-bottom:40px;
        }
        .col-4 {
            flex:1;
            min-width:300px;
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:30px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
        }
        .col-4 h1 {
            font-size:24px;
            margin-bottom:15px;
            color:#fff;
        }
        .col-4 p {
            margin-bottom:10px;
            color:rgba(255,255,255,0.7);
        }
        .col-4 img {
            max-width:100%;
            border-radius:12px;
            margin-top:15px;
        }
        .featured-image {
            text-align:center;
            margin-top:40px;
        }
        .featured-image img {
            max-width:100%;
            border-radius:24px;
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
        }
        
        .hero {
            position:relative;z-index:2;
            text-align:center;
            padding:80px 20px;
            margin-top:20px;
        }
        .hero-title {
            font-size:56px;
            font-weight:800;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            margin-bottom:20px;
            animation:fadeInUp 1s ease-out;
        }
        .hero-subtitle {
            font-size:20px;
            color:rgba(255,255,255,0.8);
            margin-bottom:40px;
            max-width:800px;
            margin-left:auto;
            margin-right:auto;
            line-height:1.6;
            animation:fadeInUp 1s ease-out 0.2s both;
        }
        .cta-button {
            display:inline-block;
            padding:16px 32px;
            background:linear-gradient(90deg,#7a00ff,#00ffe7);
            color:#0a0a12;
            text-decoration:none;
            border-radius:50px;
            font-size:16px;
            font-weight:700;
            transition:all 0.3s ease;
            animation:fadeInUp 1s ease-out 0.4s both;
        }
        .cta-button:hover {
            transform:scale(1.05);
            box-shadow:0 10px 30px rgba(122,0,255,0.5);
        }
        
        .features {
            position:relative;z-index:2;
            padding:60px 20px;
        }
        .section-title {
            font-size:36px;
            font-weight:700;
            background:linear-gradient(90deg,#7a00ff,#00ffe7);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            text-align:center;
            margin-bottom:40px;
        }
        .features-grid {
            display:flex;
            flex-wrap:wrap;
            gap:30px;
            max-width:1200px;
            margin:0 auto;
        }
        .feature-card {
            flex:1;
            min-width:300px;
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:40px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
            transition:all 0.3s ease;
        }
        .feature-card:hover {
            transform:translateY(-10px);
            box-shadow:0 15px 50px rgba(0,0,0,0.8);
        }
        .feature-icon {
            font-size:48px;
            margin-bottom:20px;
        }
        .feature-card h3 {
            font-size:24px;
            font-weight:700;
            color:#fff;
            margin-bottom:15px;
        }
        .feature-card p {
            color:rgba(255,255,255,0.7);
            line-height:1.6;
            font-size:16px;
        }
        
        .featured-section {
            position:relative;z-index:2;
            padding:60px 20px;
        }
        .featured-container {
            display:flex;
            flex-wrap:wrap;
            align-items:center;
            gap:40px;
            max-width:1200px;
            margin:0 auto;
        }
        .featured-content {
            flex:1;
            min-width:300px;
        }
        .featured-content h2 {
            font-size:32px;
            font-weight:700;
            color:#fff;
            margin-bottom:20px;
        }
        .featured-content p {
            color:rgba(255,255,255,0.7);
            line-height:1.6;
            font-size:16px;
            margin-bottom:30px;
        }
        
        .stats {
            position:relative;z-index:2;
            padding:60px 20px;
            display:flex;
            flex-wrap:wrap;
            gap:30px;
            justify-content:center;
            max-width:1200px;
            margin:0 auto;
        }
        .stat-card {
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:40px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
            text-align:center;
            min-width:200px;
            flex:1;
            transition:all 0.3s ease;
        }
        .stat-card:hover {
            transform:scale(1.05);
            box-shadow:0 15px 50px rgba(0,0,0,0.8);
        }
        .stat-number {
            font-size:48px;
            font-weight:800;
            background:linear-gradient(90deg,#7a00ff,#00ffe7);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            margin-bottom:10px;
        }
        .stat-label {
            color:rgba(255,255,255,0.7);
            font-size:16px;
        }
        
        .footer {
            position:relative;z-index:2;
            text-align:center;
            margin-top:60px;
            padding:40px 20px;
            background:rgba(30,30,50,0.7);
            backdrop-filter:blur(15px);
            border-top:1px solid rgba(255,255,255,0.1);
        }
        .footer-content {
            max-width:1200px;
            margin:0 auto;
        }
        .footer h2 {
            color:rgba(255,255,255,0.7);
            font-size:18px;
            margin-bottom:20px;
        }
        .footer-links {
            display:flex;
            flex-wrap:wrap;
            gap:20px;
            justify-content:center;
            margin-bottom:20px;
        }
        .footer-links a {
            color:rgba(255,255,255,0.7);
            text-decoration:none;
            font-size:14px;
            transition:all 0.3s ease;
        }
        .footer-links a:hover {
            color:#00ffe7;
            transform:scale(1.08);
        }
        .footer-copyright {
            color:rgba(255,255,255,0.5);
            font-size:14px;
        }
        
        @keyframes fadeInUp {
            from {
                opacity:0;
                transform:translateY(30px);
            }
            to {
                opacity:1;
                transform:translateY(0);
            }
        }
        
        @media (max-width:768px) {
            .hero-title {
                font-size:40px;
            }
            .hero-subtitle {
                font-size:18px;
            }
            .section-title {
                font-size:28px;
            }
            .feature-card {
                padding:30px;
            }
            .stat-number {
                font-size:36px;
            }
        }
        
        .latest-cars {
            position:relative;z-index:2;
            padding:60px 20px;
        }
        .cars-grid {
            display:flex;
            flex-wrap:wrap;
            gap:30px;
            max-width:1200px;
            margin:0 auto;
        }
        .car-card {
            flex:1;
            min-width:250px;
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:20px;
            padding:25px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
            transition:all 0.3s ease;
        }
        .car-card:hover {
            transform:translateY(-5px);
            box-shadow:0 15px 50px rgba(0,0,0,0.8);
        }
        .car-brand {
            font-size:20px;
            font-weight:700;
            color:#fff;
            margin-bottom:5px;
        }
        .car-model {
            font-size:16px;
            color:rgba(255,255,255,0.8);
            margin-bottom:10px;
        }
        .car-details {
            color:rgba(255,255,255,0.7);
            font-size:14px;
            margin-bottom:5px;
        }
        .car-price {
            font-size:18px;
            font-weight:700;
            color:#00ffe7;
            margin-top:10px;
        }
    </style>
</head>
<body>

<?php if(isset($_SESSION['username'])): ?>
<div class="user-info">
    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 
    <a href="seller.php">Seller Dashboard</a> | 
    <a href="logout.php">Logout</a>
</div>
<?php endif; ?>

    <div class="navbar">
        <div class="logo">CarHub</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="seller.php">Seller Center</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="add-car.php">Add Car</a>
            <a href="search.php">Search Car</a>
        </div>
    </div>

    <div class="hero">
        <h1 class="hero-title">CarHub</h1>
        <p class="hero-subtitle">Fast to sell, easy to own. Your ultimate car buying and selling platform.</p>
        <a href="search.php" class="cta-button">Explore Cars</a>
    </div>

    <section class="features">
        <h2 class="section-title">Why Choose CarHub</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Fast To Sell</h3>
                <p>Whether you're selling a used car or trading in, we prioritize speed, transparency and convenience. Get a competitive offer, finalize your sale in days, and enjoy a smooth experience from start to finish.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Easy To Own</h3>
                <p>Use our powerful search tools to filter by model, year, color, price and location to find the perfect vehicle for you. Save your favorites and compare different options side by side.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💼</div>
                <h3>Seller Center</h3>
                <p>Manage your listings, track inquiries, and close deals faster with our intuitive seller dashboard. Get access to valuable insights and tools to maximize your selling potential.</p>
            </div>
        </div>
    </section>

    <section class="latest-cars">
        <h2 class="section-title">Latest Cars For Sale</h2>
        <div class="cars-grid">
            <?php
            require_once 'db_connection.php';
            
            $sql = "SELECT brand, model, year, price, color FROM cars ORDER BY id DESC LIMIT 6";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="car-card">';
                    echo '<div class="car-brand">' . htmlspecialchars($row['brand']) . '</div>';
                    echo '<div class="car-model">' . htmlspecialchars($row['model']) . '</div>';
                    echo '<div class="car-details">Year: ' . htmlspecialchars($row['year']) . '</div>';
                    echo '<div class="car-details">Color: ' . htmlspecialchars($row['color']) . '</div>';
                    echo '<div class="car-price">$' . htmlspecialchars($row['price']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="car-card" style="text-align:center;grid-column:span 3;">No cars available yet. Be the first to list a car!</div>';
            }
            
            $conn->close();
            ?>
        </div>
    </section>

    <section class="featured-section">
        <div class="featured-container">
            <div class="featured-content">
                <h2>Featured Vehicle</h2>
                <p>Discover our handpicked selection of top-quality vehicles. Each featured car undergoes a rigorous inspection to ensure you're getting the best value for your money.</p>
                <a href="search.php" class="cta-button">View All Cars</a>
            </div>
            <div class="featured-image">
                <img src="image.png" alt="Featured Vehicle">
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="stat-card">
            <div class="stat-number">10K+</div>
            <div class="stat-label">Vehicles Listed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">50K+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">98%</div>
            <div class="stat-label">Satisfaction Rate</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Customer Support</div>
        </div>
    </section>

    <div class="footer">
        <div class="footer-content">
            <h2>Thanks for visiting CarHub</h2>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="seller.php">Seller Center</a>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
                <a href="add-car.php">Add Car</a>
                <a href="search.php">Search Car</a>
            </div>
            <div class="footer-copyright">
                &copy; 2026 CarHub. All rights reserved.
            </div>
        </div>
    </div>

    <div id="particles"></div>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
    particlesJS("particles",{
      particles:{number:{value:80},size:{value:2.5},color:{value:"#ffffff"},
      line_linked:{enable:true,distance:120,color:"#ffffff",opacity:0.15,width:1},
      move:{enable:true,speed:0.8,straight:false}},
      interactivity:{events:{onhover:{enable:true,mode:"grab"}}},retina_detect:true
    });
    </script>
</body>
</html>