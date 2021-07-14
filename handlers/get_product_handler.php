<?php
    session_start();
    require_once '../config/db_connection.php';

    $id = $_GET['product_id'];
    $_SESSION['product_id'] = $id;

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //preparing an sql statement to search email and password for whatever the user has typed and be equal to an admin user
    $sql = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $sql -> bindValue(1, "$id"); //we bind this variable to the first ? in the sql statement
    $sql -> execute(); //execute the statement

    $row = $sql->fetch();
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $product_description = $row['product_description'];
    $product_price = $row['product_price'];
    $featured = $row['featured'];

    $sql = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? AND img_main = 1");
    $sql -> bindValue(1, "$id"); //we bind this variable to the first ? in the sql statement
    $sql -> execute(); //execute the statement

    $row = $sql->fetch();
    $main_img = $row['img_filename'];
?>