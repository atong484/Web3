<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Car - CarHub</title>
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

        .search-container {
            position:relative;z-index:2;
            width: 90%;
            max-width: 900px;
            margin: 60px auto;
            text-align: center;
        }
        .search-title {
            font-size:32px;font-weight:700;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            margin-bottom: 35px;
        }
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
            align-items:center;
            margin-bottom: 40px;
        }
        .search-input {
            width: 100%;
            max-width: 260px;
            height:52px;
            background:rgba(20,20,40,0.7);
            border:1px solid rgba(255,255,255,0.15);
            border-radius:14px;
            padding:0 18px;
            font-size:16px;
            color:#fff;
            outline:none;
            transition:all 0.3s;
        }
        .search-input::placeholder{
            color:rgba(255,255,255,0.4);
        }
        .search-input:focus{
            border-color:#7a00ff;
            box-shadow:0 0 12px #7a00ff;
            transform:scale(1.03);
        }
        .search-btn {
            height:54px;
            padding:0 32px;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            color:#fff;
            border:none;
            border-radius:14px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:all 0.3s;
            box-shadow:0 6px 20px rgba(122,0,255,0.3);
        }
        .search-btn:hover {
            transform:translateY(-3px);
            box-shadow:0 10px 30px rgba(122,0,255,0.5);
        }

        .result-box {
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding: 35px;
            min-height: 220px;
            text-align: left;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
        }
        .result-title {
            font-size:20px;
            font-weight:600;
            color:rgba(255,255,255,0.9);
            margin-bottom: 20px;
        }
        .car-item {
            background:rgba(20,20,40,0.5);
            border-radius:16px;
            padding: 20px;
            border:1px solid rgba(255,255,255,0.1);
            margin-bottom:15px;
            transition:all 0.3s ease;
        }
        .car-item:hover {
            transform:translateY(-3px);
            box-shadow:0 8px 25px rgba(0,0,0,0.4);
        }
        .car-item h4{
            color:#00ffe7;
            font-size:18px;
            margin-bottom:8px;
        }
        .car-item p{
            color:rgba(255,255,255,0.75);
            font-size:15px;
            line-height:1.5;
        }
        .car-item:last-child {
            margin-bottom:0;
        }
        #resultContent{
            color:rgba(255,255,255,0.6);
            font-size:15px;
        }
        .no-results {
            text-align:center;
            padding:40px;
            color:rgba(255,255,255,0.5);
            font-size:18px;
        }
        .seller-link {
            color:rgba(255,255,255,0.7);
            font-size:14px;
            margin-top:20px;
        }
        .seller-link a {
            color:#00ffe7;
            text-decoration:none;
        }
        .seller-link a:hover {
            text-decoration:underline;
        }
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
                padding:15px;
            }
            .nav-links {
                justify-content: center;
            }
            .search-container{
                margin:40px auto;
            }
            .result-box{
                padding:25px 20px;
            }
        }
    </style>
</head>
<body>
<?php if(isset($_SESSION['username'])): ?>
<div class="user-info">
    Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> | 
    <a href="seller.php">Seller Dashboard</a> | 
    <a href="logout.php">Logout</a>
</div>
<?php endif; ?>

<div id="particles"></div>

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

<div class="search-container">
    <h2 class="search-title">Find Your Desired Car</h2>
    <form class="search-form" method="GET" action="search.php">
        <input type="text" name="model" class="search-input" placeholder="Enter car model" value="<?php echo isset($_GET['model']) ? htmlspecialchars($_GET['model']) : ''; ?>" required>
        <input type="number" name="year" class="search-input" placeholder="Enter manufacture year" min="1900" max="2026" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>" required>
        <button type="submit" class="search-btn">Search Car</button>
    </form>

    <div class="result-box">
        <h3 class="result-title">Search Results</h3>
        <div id="resultContent">
            <?php
            require_once 'db_connection.php';
            
            if (isset($_GET['model']) && isset($_GET['year'])) {
                $model = trim($_GET['model']);
                $year = trim($_GET['year']);
                
                $sql = "SELECT c.brand, c.model, c.year, c.price, c.color, s.fullname as seller_name 
                        FROM cars c 
                        JOIN sellers s ON c.seller_id = s.id 
                        WHERE c.model LIKE ? AND c.year = ?";
                
                $stmt = $conn->prepare($sql);
                $search_model = "%" . $model . "%";
                $stmt->bind_param("si", $search_model, $year);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="car-item">';
                        echo '<h4>' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '</h4>';
                        echo '<p>Year: ' . htmlspecialchars($row['year']) . '</p>';
                        echo '<p>Price: $' . htmlspecialchars($row['price']) . '</p>';
                        echo '<p>Color: ' . htmlspecialchars($row['color']) . '</p>';
                        echo '<p>Seller: ' . htmlspecialchars($row['seller_name']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-results">No cars found matching your criteria.<br>Try different keywords or check the year.</div>';
                }
                
                $stmt->close();
            } else {
                echo 'Please enter model and year to search~';
            }
            
            $conn->close();
            ?>
        </div>
    </div>
    <div class="seller-link">
        Are you a seller? <a href="seller.php">Go to Seller Center</a>
    </div>
</div>

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