<?php
    session_start();
    require_once '../config/db_connection.php';
    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_price = $_POST['product_price'];
            $id = $_SESSION['product_id'];
            
            if (isset($_POST['featured'])) {
                $featured = 1;
            }
            else{
                $featured = 0;
            }
            
            $sql = $conn->prepare("UPDATE products SET product_name = ?, product_description = ?, product_price = ?, featured = ? WHERE `product_id` = $id");
            $sql -> bindValue(1, "$product_name");
            $sql -> bindValue(2, "$product_description");
            $sql -> bindValue(3, "$product_price");
            $sql -> bindValue(4, "$featured");
            $sql -> execute();
            
            echo "<script>alert('Product Updated!')</script>";
            header("refresh:0.5; url=../admin/products.php");
            
        }
    } 
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>