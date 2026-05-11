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
    <title>Seller Center - CarHub</title>
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
        .welcome-message {
            background:rgba(30,30,50,0.6);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:30px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6);
            margin-bottom:40px;
        }
        .welcome-message p {
            color:rgba(255,255,255,0.7);
            font-size:18px;
            line-height:1.5;
        }
        .seller-details {
            margin-bottom:20px;
        }
        .detail-item {
            display:flex;
            justify-content:space-between;
            margin-bottom:8px;
            color:rgba(255,255,255,0.7);
        }
        .detail-label {
            font-weight:600;
        }
        .action-buttons {
            display:flex;
            flex-wrap:wrap;
            gap:20px;
            justify-content:center;
            margin-bottom:40px;
        }
        .action-btn {
            padding:12px 30px;
            background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
            color:#fff;
            text-decoration:none;
            border-radius:14px;
            font-size:16px;
            font-weight:600;
            transition:all 0.3s;
            box-shadow:0 6px 20px rgba(122,0,255,0.3);
        }
        .action-btn:hover {
            transform:translateY(-3px);
            box-shadow:0 10px 30px rgba(122,0,255,0.5);
        }
        .section-title {
            font-size:24px;
            font-weight:700;
            margin-bottom:25px;
            color:#fff;
        }
        .car-grid {
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));
            gap:30px;
        }
        .car-card {
            background:linear-gradient(135deg, rgba(30,30,50,0.8), rgba(40,40,60,0.6));
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:25px;
            border:1px solid rgba(255,255,255,0.1);
            box-shadow:0 10px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.05);
            transition:all 0.3s ease;
            position:relative;
            overflow:hidden;
        }
        .car-card::before {
            content:'';
            position:absolute;
            top:0;
            left:-100%;
            width:100%;
            height:100%;
            background:linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition:all 0.6s ease;
        }
        .car-card:hover {
            transform:translateY(-8px) scale(1.02);
            box-shadow:0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(122,0,255,0.3);
            border-color:rgba(122,0,255,0.5);
        }
        .car-card:hover::before {
            left:100%;
        }
        .car-image {
            margin-bottom:20px;
            height:200px;
            overflow:hidden;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,0.5);
            transition:all 0.3s ease;
        }
        .car-image img {
            width:100%;
            height:100%;
            object-fit:cover;
            border-radius:12px;
            transition:all 0.5s ease;
        }
        .car-card:hover .car-image img {
            transform:scale(1.1);
        }
        .car-title {
            font-size:20px;
            font-weight:700;
            margin-bottom:15px;
            color:#fff;
            background:linear-gradient(90deg,#7a00ff,#00ffe7);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            transition:all 0.3s ease;
        }
        .car-card:hover .car-title {
            background:linear-gradient(90deg,#00ffe7,#ff00c8);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        .car-details {
            margin-bottom:15px;
        }
        .car-detail-item {
            display:flex;
            justify-content:space-between;
            margin-bottom:8px;
            color:rgba(255,255,255,0.7);
        }
        .car-price {
            font-size:20px;
            font-weight:700;
            color:#00ffe7;
            margin-top:10px;
            text-shadow:0 0 10px rgba(0,255,231,0.5);
            transition:all 0.3s ease;
        }
        .car-card:hover .car-price {
            transform:scale(1.05);
            text-shadow:0 0 20px rgba(0,255,231,0.8);
        }
        .car-status {
            margin-top:10px;
            margin-bottom:15px;
        }
        .status-badge {
            display:inline-block;
            padding:6px 12px;
            border-radius:20px;
            font-size:14px;
            font-weight:600;
        }
        .status-badge.active {
            background:rgba(0, 255, 119, 0.2);
            color:#00ff77;
        }
        .status-badge.inactive {
            background:rgba(255, 0, 0, 0.2);
            color:#ff0000;
        }
        .car-actions {
            display:flex;
            gap:10px;
            margin-top:15px;
        }
        .action-btn.small {
            padding:8px 16px;
            font-size:14px;
            border-radius:10px;
            transition:all 0.3s ease;
            position:relative;
            overflow:hidden;
        }
        .action-btn.small::before {
            content:'';
            position:absolute;
            top:50%;
            left:50%;
            width:0;
            height:0;
            background:rgba(255,255,255,0.2);
            border-radius:50%;
            transform:translate(-50%, -50%);
            transition:all 0.3s ease;
        }
        .action-btn.small:hover::before {
            width:300px;
            height:300px;
        }
        .action-btn.small:hover {
            transform:translateY(-2px);
            box-shadow:0 6px 20px rgba(122,0,255,0.5);
        }
        .action-btn.small.delete {
            background:linear-gradient(90deg,#ff0000,#ff6600);
            box-shadow:0 4px 15px rgba(255,0,0,0.3);
        }
        .action-btn.small.delete:hover {
            box-shadow:0 6px 20px rgba(255,0,0,0.5);
        }
        .no-cars {
            text-align:center;
            grid-column:1/-1;
            padding:40px;
            color:rgba(255,255,255,0.7);
            font-size:18px;
        }
        .logout-btn {
            background:linear-gradient(90deg,#ff0000,#ff6600);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body>
<?php
require_once 'db_connection.php';
$seller_id = $_SESSION['seller_id'];
$username = $_SESSION['username'];

$sql_seller = "SELECT fullname, email, phone, address FROM sellers WHERE id = ?";
$stmt_seller = $conn->prepare($sql_seller);
$stmt_seller->bind_param("i", $seller_id);
$stmt_seller->execute();
$result_seller = $stmt_seller->get_result();
$seller_data = $result_seller->fetch_assoc();
$stmt_seller->close();

$sql_cars = "SELECT id, brand, model, year, price, color FROM cars WHERE seller_id = ?";
$stmt_cars = $conn->prepare($sql_cars);
$stmt_cars->bind_param("i", $seller_id);
$stmt_cars->execute();
$result_cars = $stmt_cars->get_result();
?>
<div id="particles"></div>
<div class="user-info">
    Logged in as: <?php echo htmlspecialchars($username); ?> | 
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
    <h1 class="title">Seller Center</h1>
    
    <div class="welcome-message">
        <p>Welcome back, <?php echo htmlspecialchars($seller_data['fullname']); ?>! This is your seller dashboard.</p>
        <div class="seller-details">
            <div class="detail-item">
                <span class="detail-label">Full Name:</span>
                <span><?php echo htmlspecialchars($seller_data['fullname']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <span><?php echo htmlspecialchars($seller_data['email']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone:</span>
                <span><?php echo htmlspecialchars($seller_data['phone']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Address:</span>
                <span><?php echo htmlspecialchars($seller_data['address']); ?></span>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="add-car.php" class="action-btn">Add New Car</a>
        <a href="search.php" class="action-btn">Search Cars</a>
        <a href="logout.php" class="action-btn logout-btn">Logout</a>
    </div>

    <div class="car-list">
        <h2 class="section-title">Your Listed Vehicles</h2>
        
        <div class="car-grid">
            <?php
            if ($result_cars->num_rows > 0) {
                while($row = $result_cars->fetch_assoc()) {
                    $car_image = '';
                    switch(strtolower($row['brand'])) {
                        case 'toyota':
                            $car_image = 'toyota.png';
                            break;
                        case 'honda':
                            $car_image = 'honda.png';
                            break;
                        case 'tesla':
                            $car_image = 'tesla.png';
                            break;
                        case 'land rover':
                        case 'range rover':
                            $car_image = 'range rover.png';
                            break;
                        default:
                            $car_image = 'car-default.png';
                    }
                    ?>
                    <div class="car-card">
                        <div class="car-image">
                            <img src="<?php echo $car_image; ?>" alt="<?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?>">
                        </div>
                        <div class="car-info">
                            <div class="car-title"><?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?></div>
                            <div class="car-details">
                                <div class="car-detail-item">
                                    <span>Brand:</span>
                                    <span><?php echo htmlspecialchars($row['brand']); ?></span>
                                </div>
                                <div class="car-detail-item">
                                    <span>Model:</span>
                                    <span><?php echo htmlspecialchars($row['model']); ?></span>
                                </div>
                                <div class="car-detail-item">
                                    <span>Year:</span>
                                    <span><?php echo htmlspecialchars($row['year']); ?></span>
                                </div>
                                <div class="car-detail-item">
                                    <span>Color:</span>
                                    <span><?php echo htmlspecialchars($row['color']); ?></span>
                                </div>
                            </div>
                            <div class="car-price">$<?php echo htmlspecialchars($row['price']); ?></div>
                            <div class="car-status">
                                <span class="status-badge active">Active</span>
                            </div>
                            <div class="car-actions">
                                <form method="POST" action="delete-car.php" style="display:inline;">
                                    <input type="hidden" name="car_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="action-btn small delete" onclick="return confirm('Are you sure you want to delete this car?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-cars">You have not listed any cars yet. <a href="add-car.php" style="color:#00ffe7;">Add your first car</a></div>';
            }
            
            $stmt_cars->close();
            $conn->close();
            ?>
        </div>
    </div>
</div>

<script>
    particlesJS('particles', {
        "particles": {
            "number": {
                "value": 80,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#3498db"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                }
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {
                    "enable": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#3498db",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "grab"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 140,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "push": {
                    "particles_nb": 4
                }
            }
        },
        "retina_detect": true
    });
</script>
</body>
</html>