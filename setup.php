<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_car_sale";

$conn = new mysqli($servername, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->select_db($dbname);

$sql = "-- 汽车销售平台数据库脚本
-- 表：sellers（用户）、cars（车辆）

-- 1. 用户表
CREATE TABLE IF NOT EXISTS sellers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    address VARCHAR(200),
    phone VARCHAR(50),
    email VARCHAR(100),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

-- 默认管理员
INSERT IGNORE INTO sellers (fullname, address, phone, email, username, password)
VALUES
('Admin', '', '', 'admin@test.com', 'admin', '123456');

-- 2. 车辆表
CREATE TABLE IF NOT EXISTS cars (
    id INT PRIMARY KEY AUTO_INCREMENT,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year VARCHAR(20) NOT NULL,
    price VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL
);

-- 默认车辆
INSERT IGNORE INTO cars (brand, model, year, price, color)
VALUES
('Toyota', 'Camry', '2020', '25000', 'White'),
('Honda', 'Civic', '2021', '23000', 'Black');";

if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created and data inserted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>