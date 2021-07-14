<?php
session_start();
require_once 'config/db_connection.php';
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$status = ""; //initiating the variable to use later
if (isset($_POST['product_id']) && $_POST['product_id']!=""){
    $product_id = $_POST['product_id']; //For product ID to exist, someone must have pressed buy on a product

    try{
        //We search for the product that has been clicked on
        $sql = $conn->prepare('SELECT * FROM products WHERE product_id= :product_id');
        $sql -> execute(['product_id' => $product_id]); //execute the statement
        $row = $sql->fetch();
    
        $product_name = $row['product_name'];
        $product_id = $row['product_id'];
        $product_price = $row['product_price'];

        //You could perform another search here to obtain the product image
        $sql2 = $conn->prepare('SELECT img_filename FROM product_images WHERE product_id = :product_id AND img_main = 1');
        $sql2 -> execute(['product_id' => $product_id]); //execute the statement
        $row2 = $sql2->fetch();
        $product_image = $row2['img_filename'];
    
        $cartArray = array(
            $product_id=>array(
            'product_name'=>$product_name,
            'product_id'=>$product_id,
            'product_price'=>$product_price,
            'product_image'=>$product_image,
            'product_quantity'=>1
            )
        );
        // we perform some logic that detects if the product is already in the basket.
        // If it is, we display an error message. Increasing quantity is handled on the cart page
        if(empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = "<div class='box'>Product is added to your cart!</div>";
        }
        else{
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if(in_array($product_id,$array_keys)) {
                $status = "<div class='box' style='color:red;'>
                Product is already added to your cart!</div>";	
            } 
            else {
                $_SESSION["shopping_cart"] = $_SESSION["shopping_cart"] + $cartArray;
                $status = "<div class='box'>Product is added to your cart!</div>";
            }
 
        }
    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
    }
}

function DisplayProducts($conn){
    try {
        $sql = $conn->prepare("SELECT * FROM products ORDER BY product_id DESC");
                
        $sql -> execute(); //execute the statement
        $product_array = $sql->fetchAll();
        
        if($sql->rowCount()) { //check if we have results by counting rows
            foreach($product_array as $row)
                {   
                    //Loop here to obtain images linked to product
                    $current_product = $row['product_id'];
                    
                    try{
                        $sql2 = $conn->prepare('SELECT img_filename FROM product_images WHERE product_id = :product_id AND img_main = 1');
                        $sql2 -> execute(['product_id' => $current_product]); //execute the statement
                        $row2 = $sql2->fetch();
                        $product_image = $row2['img_filename'];
                    }
                    catch(PDOException $e)
                    {
                        echo $sql2 . "<br>" . $e->getMessage(); //If we are not successful we will see an error
                    }
                    
                    //include a code snippet to show preview of each product
                    echo "<div class='container'>";
                    echo "<form method='post' action=''>
                            <a href='see_product.php?id=" . $row['product_id'] . "' class='button'>
                            <img class='product_image' src='".$product_image."'>
                            <input type='hidden' name='product_id' value=".$row['product_id']." />
                            
                            <div class='name'>".$row['product_name']."</div>
                            <div class='price'>£".number_format($row['product_price'], 2)."</div>
                            </a>
                            <br>";
                            if ($_SESSION['login'] == "true"){
                                echo "<button type='submit' class='buy'>Add to Basket</button>";
                            }
                    echo "</form>
                    </div>";
                }   
                
            }
        else
            {
                echo 'no products to show'; //message to display if the search returned no results
            }    
        }
    catch(PDOException $e)
        {
        //echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
        }
}

function DisplayFeaturedProducts($conn){
    try {
        $sql = $conn->prepare("SELECT * FROM products WHERE featured = 1 ORDER BY product_id DESC");
                
        $sql -> execute(); //execute the statement
        $product_array = $sql->fetchAll();
        
        if($sql->rowCount()) { //check if we have results by counting rows
            foreach($product_array as $row)
                {   
                    //Loop here to obtain images linked to product
                    $current_product = $row['product_id'];
                    
                    try{
                        $sql2 = $conn->prepare('SELECT img_filename FROM product_images WHERE product_id = :product_id AND img_main = 1');
                        $sql2 -> execute(['product_id' => $current_product]); //execute the statement
                        $row2 = $sql2->fetch();
                        $product_image = $row2['img_filename'];
                    }
                    catch(PDOException $e)
                    {
                        echo $sql2 . "<br>" . $e->getMessage(); //If we are not successful we will see an error
                    }
                    
                    //include a code snippet to show preview of each product
                    echo "<div class='container'>";
                    echo "<form method='post' action=''>
                            <a href='see_product.php?id=" . $row['product_id'] . "' class='button'>
                            <img class='product_image' src='".$product_image."'>
                            <input type='hidden' name='product_id' value=".$row['product_id']." />
                            
                            <div class='name'>".$row['product_name']."</div>
                            <div class='price'>£".number_format($row['product_price'], 2)."</div>
                            </a>
                            <br>";
                            if ($_SESSION['login'] == "true"){
                                echo "<button type='submit' class='buy'>Add to Basket</button>";
                            }
                    echo "</form>
                    </div>";
                }   
                
            }
        else
            {
                echo 'no products to show'; //message to display if the search returned no results
            }    
        }
    catch(PDOException $e)
        {
        //echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    <style>body{font-family: 'Ubuntu', sans-serif; background-color:#eee; margin: 0;}</style>
    <title>Products</title>
    <style>
    .cart_div{
        margin-left: 6%;
        margin-top: 1%;
        width: fit-content;
    }
    .cartlink{
        text-decoration: none;
    }
    .cartn:hover{
        background-color: #cccccc52;
        border-radius: 5px;
    }
    .cartn{
        color: #008CBA;
        padding: 1%;
    }
    .cartimg{
        width: 5%;
    }
    .buy{
        background-color: #008CBA;
        color: white;
        border: none;
        padding: 3%;
        border-radius: 5px;
        border: 1px solid #008CBA;
    }
    .price{
        font-weight: 700;
    }
    .buy:hover{
        background-color: #eee;
        border: 1px solid #008CBA;
        cursor: pointer;
        color: #008CBA;
        transition: background-color 0.3s linear;
    }
    .product_wrapper{
        margin: 10px 1% 0 0;
        width: 40%;
        padding: 4%;
        height: inherit;
    }
    .product_image{
        width: 100px;
        height: 140px;
    }
    .content{
      margin: 2% 5%;
      width: 90%;
      align-content: center;
    }
    .container{
      border: 2px solid #008CBA;
      border-radius: 5px;
      width: 10%;
      text-align: center;
      padding: 1%;
      margin: 1%;
      transition: background-color 0.3s linear;
      display: inline-table;
    }
    .container:hover{
        background-color: #00000014;
        transition: background-color 0.3s linear;
    }
    .button{
        text-decoration: none;
        color: black;
        transition: color 0.3s linear;
    }
    .button:hover{
        color: #008CBA;
        transition: color 0.3s linear;
    }
    </style>
</head>
<body>
    <?php 
        if ($_SESSION['login'] == "true") {
            include 'navlogin.php';
            include 'cart_count.php';
        }
        else{
            include 'nav.php';
        }
    ?>
    <div class="content">
        <?php include 'product_search_form.php'; ?>
        <div class="featured">
        <h3>Featured Products</h3>
            <?php DisplayFeaturedProducts($conn); ?>
        </div>
        <hr>
        <?php 

            DisplayProducts($conn); 
        ?>

        <div style="clear:both;"></div>

        <div class="message_box" style="margin:10px 0px;">
            <?php echo $status; ?>
        </div>

    </div>
</body>
</html>

