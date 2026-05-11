<?php
session_start();

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - CarHub</title>
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
            width: 90%;
            max-width: 620px;
            margin: 50px auto;
            padding: 40px 35px;
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
        }
        .title {
            font-size:28px;font-weight:700;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            text-align:center;
            margin-bottom: 35px;
        }
        .form-group {
            margin-bottom:22px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color:rgba(255,255,255,0.85);
            font-size:15px;
        }
        .form-group input, .form-group select {
            width: 100%;
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
        .form-group input::placeholder{
            color:rgba(255,255,255,0.4);
        }
        .form-group input:focus, .form-group select:focus{
            border-color:#7a00ff;
            box-shadow:0 0 12px #7a00ff;
            transform:scale(1.03);
        }
        .submit-btn {
            width:100%;
            height:54px;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            color:#fff;
            border:none;
            border-radius:14px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:all 0.3s;
            margin-top:10px;
            box-shadow:0 6px 20px rgba(122,0,255,0.3);
        }
        .submit-btn:hover {
            transform:translateY(-3px);
            box-shadow:0 10px 30px rgba(122,0,255,0.5);
        }
        .msg{
            position:relative;z-index:2;
            text-align:center;
            color:#fff;
            margin:18px 0;
            font-size:15px;
        }
        .success-msg {
            background:rgba(0,255,0,0.1);
            border:1px solid #00ff55;
            border-radius:8px;
            padding:12px;
            margin-bottom:20px;
            text-align:center;
            color:#00ff55;
        }
        .error-msg {
            background:rgba(255,0,0,0.1);
            border:1px solid #ff5555;
            border-radius:8px;
            padding:12px;
            margin-bottom:20px;
            text-align:center;
            color:#ff5555;
        }
        .back-link {
            display:block;
            text-align:center;
            margin-top:20px;
            color:rgba(255,255,255,0.7);
        }
        .back-link a {
            color:#00ffe7;
            text-decoration:none;
        }
        .back-link a:hover {
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
            .container{
                padding:30px 20px;
                margin:30px auto;
            }
        }
    </style>
</head>
<body>
<?php
require_once 'db_connection.php';

if (isset($_GET['success'])) {
    echo '<div class="success-msg">' . htmlspecialchars($_GET['success']) . '</div>';
}
if (isset($_GET['error'])) {
    echo '<div class="error-msg">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>
<div id="particles"></div>
<div class="user-info">
    Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> | 
    <a href="seller.php">Seller Dashboard</a> | 
    <a href="logout.php">Logout</a>
</div>

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

<div class="container">
    <h2 class="title">Add Car Information</h2>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label>Car Brand</label>
            <input type="text" name="brand" placeholder="e.g. Toyota, Honda, BMW" required>
        </div>

        <div class="form-group">
            <label>Car Model</label>
            <input type="text" name="model" placeholder="e.g. Camry, Civic, X5" required>
        </div>

        <div class="form-group">
            <label>Manufacture Year</label>
            <input type="number" name="year" placeholder="e.g. 2020" min="1900" max="2026" required>
        </div>

        <div class="form-group">
            <label>Price (USD)</label>
            <input type="number" name="price" placeholder="Enter car price" min="1" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Car Color</label>
            <input type="text" name="color" placeholder="Enter car color" required>
        </div>

        <button type="submit" class="submit-btn">Submit Car Information</button>
    </form>
    
    <div class="back-link">
        <a href="seller.php">← Back to Seller Dashboard</a>
    </div>
    <div class="msg" id="tip"></div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $year = trim($_POST['year']);
    $price = trim($_POST['price']);
    $color = trim($_POST['color']);
    $seller_id = $_SESSION['seller_id'];
    
    if (empty($brand) || empty($model) || empty($year) || empty($price) || empty($color)) {
        header("Location: add-car.php?error=Please fill in all fields");
        exit();
    }
    
    if (!is_numeric($year) || $year < 1900 || $year > 2026) {
        header("Location: add-car.php?error=Please enter a valid year (1900-2026)");
        exit();
    }
    
    if (!is_numeric($price) || $price <= 0) {
        header("Location: add-car.php?error=Please enter a valid price");
        exit();
    }
    
    $sql = "INSERT INTO cars (seller_id, brand, model, year, price, color) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $seller_id, $brand, $model, $year, $price, $color);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: add-car.php?success=Car added successfully!");
        exit();
    } else {
        header("Location: add-car.php?error=Error: " . urlencode($conn->error));
        exit();
    }
}
?>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles",{
        particles:{number:{value:80},size:{value:2.5},color:{value:"#ffffff"},
        line_linked:{enable:true,distance:120,color:"#ffffff",opacity:0.15,width:1},
        move:{enable:true,speed:0.8,straight:false}},
        interactivity:{events:{onhover:{enable:true,mode:"grab"}}},retina_detect:true
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const year = document.querySelector('input[name="year"]').value;
        const price = document.querySelector('input[name="price"]').value;
        const tip = document.getElementById('tip');
        
        tip.innerText = '';
        tip.style.color = '';
        
        if(year < 1900 || year > 2026) {
            tip.innerText = 'Please enter a valid year (1900-2026)';
            tip.style.color = '#ff4444';
            event.preventDefault();
            return false;
        }
        if(price <= 0) {
            tip.innerText = 'Price must be greater than 0';
            tip.style.color = '#ff4444';
            event.preventDefault();
            return false;
        }
        return true;
    });
</script>
</body>
</html>