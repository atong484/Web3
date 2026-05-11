<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 包含数据库连接文件
    require_once 'db_connection.php';
    
    $fullname = trim($_POST['fullname']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $repwd = $_POST['repwd'];
    
    $error = '';
    $success = '';
    
    // 验证输入
    if (empty($fullname) || empty($address) || empty($phone) || 
        empty($email) || empty($username) || empty($password) || empty($repwd)) {
        $error = 'Please fill in all fields';
    } elseif ($password !== $repwd) {
        $error = 'Passwords do not match';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        // 检查用户名和邮箱是否已存在
        $check_sql = "SELECT id FROM sellers WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error = 'Username or Email already exists';
        } else {
            // 密码哈希
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // 插入用户
            $sql = "INSERT INTO sellers (fullname, address, phone, email, username, password) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $fullname, $address, $phone, $email, $username, $hashed_password);
            
            if ($stmt->execute()) {
                $success = 'Registration successful! Welcome, ' . htmlspecialchars($fullname) . '.';
                // 可以重定向到登录页面
                // header("Location: login.php?success=Registration successful. Please login.");
                // exit();
            } else {
                $error = 'Registration failed. Please try again.';
            }
            
            $stmt->close();
        }
        $check_stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - CarHub</title>
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
  width:100%;max-width:400px;
  margin: 60px auto;
  background:rgba(30,30,50,0.6);
  backdrop-filter:blur(20px);
  border-radius:24px;padding:40px 30px;
  border:1px solid rgba(255,255,255,0.1);
  box-shadow:0 10px 40px rgba(0,0,0,0.6);
}
.title{
  font-size:30px;font-weight:700;
  background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  text-align:center;margin-bottom:8px;
}
.sub{
  color:rgba(255,255,255,0.6);
  text-align:center;margin-bottom:25px;
}
.input-box{margin-bottom:18px}
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
  border-color:#7a00ff;
  box-shadow:0 0 12px #7a00ff;
  transform:scale(1.03);
}
.reg-btn{
  width:100%;height:54px;
  background:linear-gradient(90deg,#7a00ff,#00ffe7,#ff00c8);
  color:#fff;border:none;border-radius:14px;
  font-size:16px;font-weight:600;cursor:pointer;
  transition:all 0.3s;margin-top:10px;
  box-shadow:0 6px 20px rgba(122,0,255,0.3);
}
.reg-btn:hover{
  transform:translateY(-3px);
  box-shadow:0 10px 30px rgba(122,0,255,0.5);
}
.link{
  text-align:center;margin-top:24px;
  color:rgba(255,255,255,0.6);
}
.link a{
  color:#ff00c8;text-decoration:none;font-weight:500;
}
.msg{
  position:relative;z-index:2;
  text-align:center;color:#fff;margin-top:16px;font-size:14px;
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
    margin: 30px auto;
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

<div class="card">
  <h2 class="title">Create Account</h2>
  <p class="sub">Register your new account</p>
  
  <?php if(isset($success) && !empty($success)): ?>
  <div class="success-msg"><?php echo $success; ?></div>
  <?php endif; ?>
  
  <?php if(isset($error) && !empty($error)): ?>
  <div class="error-msg"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="input-box">
      <input type="text" name="fullname" placeholder="Full Name" 
             value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
    </div>
    <div class="input-box">
      <input type="text" name="address" placeholder="Address" 
             value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required>
    </div>
    <div class="input-box">
      <input type="text" name="phone" placeholder="Phone Number" 
             value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
    </div>
    <div class="input-box">
      <input type="email" name="email" placeholder="Email" 
             value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
    </div>
    <div class="input-box">
      <input type="text" name="username" placeholder="Username" 
             value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
    </div>
    <div class="input-box">
      <input type="password" name="password" placeholder="Password" required>
    </div>
    <div class="input-box">
      <input type="password" name="repwd" placeholder="Confirm Password" required>
    </div>
    <button type="submit" class="reg-btn">Register</button>
  </form>
  <div class="link">Already have an account? <a href="login.php">Back to Login</a></div>
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

// 前端验证
document.querySelector('form').addEventListener('submit', function(event) {
  let fullname = document.querySelector('input[name="fullname"]').value.trim();
  let address = document.querySelector('input[name="address"]').value.trim();
  let phone = document.querySelector('input[name="phone"]').value.trim();
  let email = document.querySelector('input[name="email"]').value.trim();
  let user = document.querySelector('input[name="username"]').value.trim();
  let pwd = document.querySelector('input[name="password"]').value.trim();
  let repwd = document.querySelector('input[name="repwd"]').value.trim();
  let tip = document.getElementById('tip');

  if(!fullname || !address || !phone || !email || !user || !pwd || !repwd){
    tip.innerText = 'Please fill in all fields';
    tip.style.color = '#ff5555';
    event.preventDefault();
    return;
  }
  if(pwd !== repwd){
    tip.innerText = 'Passwords do not match';
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