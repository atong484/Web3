<?php
session_start();


if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: login.php?message=You have been logged out");
    exit();
}

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'db_connection.php';
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {

        $error = 'Please fill in all fields';
    } else {
        $sql = "SELECT id, username, password FROM sellers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['seller_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                header("Location: seller.php");
                exit();
            }
        }

        $error = 'Invalid username or password';
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Car Sales Platform</title>
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

.card{
  position:relative;z-index:2;
  width:100%;max-width:380px;
  margin: 80px auto;
  background:rgba(30,30,50,0.6);
  backdrop-filter:blur(20px);
  border-radius:24px;padding:40px 30px;
  border:1px solid rgba(255,255,255,0.1);
  box-shadow:0 10px 40px rgba(0,0,0,0.6);
}
.title{
  font-size:30px;font-weight:700;
  background:linear-gradient(90deg,#00ffe7,#ff00c8,#7a00ff);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  text-align:center;margin-bottom:8px;
}
.sub{
  color:rgba(255,255,255,0.6);
  text-align:center;margin-bottom:35px;
}
.input-box{margin-bottom:22px}
input{
  width:100%;height:52px;
  background:rgba(20,20,40,0.7);
  border:1px solid rgba(255,255,255,0.15);
  border-radius:14px;padding:0 18px;
  font-size:16px;color:#fff;outline:none;
  transition:all 0.3s;
}
input::placeholder{color:rgba(255,255,255,0.4)}
input:focus{
  border-color:#00ffe7;
  box-shadow:0 0 12px #00ffe7;
  transform:scale(1.03);
}
.login-btn{
  width:100%;height:54px;
  background:linear-gradient(90deg,#ff00c8,#7a00ff,#00ffe7);
  color:#fff;border:none;border-radius:14px;
  font-size:16px;font-weight:600;cursor:pointer;
  transition:all 0.3s;margin-top:10px;
  box-shadow:0 6px 20px rgba(255,0,200,0.3);
}
.login-btn:hover{
  transform:translateY(-3px);
  box-shadow:0 10px 30px rgba(255,0,200,0.5);
}
.link{
  text-align:center;margin-top:24px;
  color:rgba(255,255,255,0.6);
}
.link a{
  color:#00ffe7;text-decoration:none;font-weight:500;
}
.msg{
  position:relative;z-index:2;
  text-align:center;color:#fff;margin-top:16px;font-size:14px;
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
.success-msg {
  background:rgba(0,255,0,0.1);
  border:1px solid #00ff55;
  border-radius:8px;
  padding:12px;
  margin-bottom:20px;
  text-align:center;
  color:#00ff55;
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
  .card{
    margin: 40px auto;
  }
}
</style>
</head>
<body>
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

<?php

if (isset($_GET['message'])) {
    echo '<div class="success-msg">' . htmlspecialchars($_GET['message']) . '</div>';
}
?>

<div class="card">
  <h2 class="title">Welcome Back</h2>
  <p class="sub">Please login to continue
  
  <?php

  if (isset($error)) {
    echo '<div class="error-msg">' . htmlspecialchars($error) . '</div>';
  }
  ?>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="input-box">
      <input type="text" id="username" name="username" placeholder="Enter your username" required>
    </div>
    <div class="input-box">
      <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <button type="submit" class="login-btn">Login</button>
  </form>
  <div class="link">Don't have an account? <a href="register.php">Register Now</a></div>
</div>
<div class="msg" id="tip"></div>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
particlesJS("particles",{
  particles:{number:{value:80},size:{value:2.5},color:{value:"#ffffff"},
  line_linked:{enable:true,distance:120,color:"#ffffff",opacity:0.15,width:1},
  move:{enable:true,speed:0.8,straight:false}},
  interactivity:{events:{onhover:{enable:true,mode:"grab"}}},retina_detect:true
});

document.querySelector('form').addEventListener('submit', function(event) {
  let user = document.getElementById('username').value.trim();
  let pwd = document.getElementById('password').value.trim();
  let tip = document.getElementById('tip');
  
  tip.innerText = '';
  tip.style.color = '';
  
  if(!user || !pwd){
    tip.innerText = 'Please fill in all fields';
    tip.style.color = '#ff5555';
    event.preventDefault();
    return;
  }
  
  if(pwd.length < 6){
    tip.innerText = 'Password should be at least 6 characters';
    tip.style.color = '#ff5555';
    event.preventDefault();
  }
});
</script>
</body>
</html>
