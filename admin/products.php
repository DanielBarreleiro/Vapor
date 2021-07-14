<?php
session_start();
if ($_SESSION['alogin'] == "true") {
    require_once '../config/db_connection.php';
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function GetProducts($conn){
        $sql = $conn->prepare("SELECT * FROM products");
        $sql -> execute();
                    
        if($sql->rowCount()) {
            while ($row = $sql->fetch()){
                    echo '<br>';
                    echo 'Product ID: ' . $row['product_id'] . '<br>';
                    echo 'Name: ' . $row['product_name'] . '<br>';
                    echo 'Description: ' . utf8_encode($row['product_description']) . '<br>';
                    echo 'Price: £' . $row['product_price'] . '<br><br>';
                    
                    echo '<a href="update_product.php?product_id='.$row['product_id'].'" class="button" onclick="return confirm(\'Are you sure you want to update this product?\');">Update this Product</a>';
                    echo '<hr>';
                    
            }
        }
        else{
            echo 'No Products Found';
        }
    }

    function GetOptions($conn){
        $sql = $conn->prepare("SELECT product_name FROM products");
        $sql -> execute();

        if($sql->rowCount()) {
            while ($row = $sql->fetch()){
                    echo '<option value=' . $row['product_name'] . '>' . $row['product_name'] . '</option>';  
            }
        }
        else{
                echo '<option value="No Products found">No Products found</option>';
        }
    }

    function GetSelectedProduct($conn){
        $product_name = $_POST['product_name'];

        $sql = $conn->prepare("SELECT * FROM products WHERE product_name LIKE ?");
        $sql -> bindValue(1, "%$product_name%");
        $sql -> execute();
        
        if($sql->rowCount()) {
            while ($row = $sql->fetch()){
                echo '<br>';
                echo 'Product ID: ' . $row['product_id'] . '<br>';
                echo 'Name: ' . $row['product_name'] . '<br>';
                echo 'Description: ' . utf8_encode($row['product_description']) . '<br>';
                echo 'Price: £' . $row['product_price'] . '<br><br>';
                
                echo '<a href="update_product.php?product_id='.$row['product_id'].'" class="button" onclick="return confirm(\'Are you sure you want to update this product?\');">Update this Product</a>';
                echo '<hr><br>';
                    
            }
        }
        else{
            echo 'no results returned'; //message to display if the search returned no results
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    <style>body{font-family: 'Ubuntu', sans-serif; background-color:#eee; margin: 0;}</style>
    <title>Products</title>
    <style>
        .f1{
            color:#ff0000;
            font-weight:bold;
        }
        .button {
            
            padding:5px;
            background-color:green;
            color:white;
            border-radius:3px;
            margin-top:3px;
            display:block;
            width:130px;
            text-decoration:none;
        }
        .dbutton {
            
            padding:5px;
            background-color:red;
            color:white;
            border-radius:3px;
            margin-top:3px;
            display:block;
            width:130px;
            text-decoration:none;
        }
        .content{
            margin: 2%;
            width: 90%;
        }
    </style>
</head>
<body>
    <?php include 'nav.php' ?>
    <div class="content">
        <form action="products.php" method="post">
            <label>Search Existing Products:</label>
            <select name="product_name">
            <?php GetOptions($conn); ?>
            </select>
            <br>
            <input type="submit" value="Search" name="search">
            <input type="submit" value="Reset Filter" name="reset">
        </form>

        <?php
            if (isset($_POST['search'])) {
                GetSelectedProduct($conn);
            }

            if (!isset($_POST['search']) || isset($_POST['reset'])){
                GetProducts($conn);
            } 
        ?>
    </div>
</body>
</html>
<?php
}
else{
  header("Location: ../login.php");
}
?>