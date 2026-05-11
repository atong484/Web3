<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_car_sale";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("MySQL连接失败: " . $conn->connect_error);
}


if (!$conn->select_db($dbname)) {

    $create_db_sql = "CREATE DATABASE IF NOT EXISTS $dbname 
                     CHARACTER SET utf8mb4 
                     COLLATE utf8mb4_general_ci";
    
    if ($conn->query($create_db_sql) === TRUE) {
        $conn->select_db($dbname);
        echo "数据库 '$dbname' 创建成功<br>";
    } else {
        die("创建数据库失败: " . $conn->error);
    }
}


$check_tables_sql = "SHOW TABLES LIKE 'sellers'";
$result = $conn->query($check_tables_sql);

if ($result->num_rows == 0) {
    echo "检测到数据库为空，正在创建表结构...<br>";
    
    $create_sellers = "CREATE TABLE sellers (
        id INT PRIMARY KEY AUTO_INCREMENT,
        fullname VARCHAR(100) NOT NULL,
        address VARCHAR(200),
        phone VARCHAR(50),
        email VARCHAR(100),
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    
    $create_cars = "CREATE TABLE cars (
        id INT PRIMARY KEY AUTO_INCREMENT,
        seller_id INT NOT NULL,
        brand VARCHAR(100) NOT NULL,
        model VARCHAR(100) NOT NULL,
        year VARCHAR(20) NOT NULL,
        price VARCHAR(50) NOT NULL,
        color VARCHAR(50) NOT NULL
    )";
    
    if ($conn->query($create_sellers) === TRUE && 
        $conn->query($create_cars) === TRUE) {
        echo "表结构创建成功！<br>";
    } else {
        die("创建表失败: " . $conn->error);
    }
}
?>