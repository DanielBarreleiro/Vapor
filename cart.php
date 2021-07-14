<?php
session_start();
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove"){
    
if(!empty($_SESSION["shopping_cart"])) {
    
    foreach($_SESSION["shopping_cart"] as $key => $value) {
        #echo "product id is" .$_POST['product_id']."</br>";
          #echo "key is" .$key."</br>";
          
      if($_POST["product_id"] == $key){
          

   
      unset($_SESSION["shopping_cart"][$key]);
      $status = "<div class='box' style='color:red;'>
      Product removed from your cart!</div>";
      }
      if(empty($_SESSION["shopping_cart"]))
      unset($_SESSION["shopping_cart"]);
      }		
}
}
 
if (isset($_POST['action']) && $_POST['action']=="change"){

  foreach($_SESSION["shopping_cart"] as &$value){
    if($value['product_id'] === $_POST["product_id"]){
        
        $value['product_quantity'] = $_POST["product_quantity"];
        break; // Stop the loop after we've found the product
    }
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
    <title>Basket</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto auto auto;
            /*grid-gap: 10px;*/
            
            padding: 10px;
        }
        .grid-item-header{
            background-color:#999;
            padding:10px 0 10px 0;
            margin:0 0 10px 0;
        }
        .grid-item-header p{
            margin:0 0 0 10px;
        }
        .total-text{
            text-align:right;
            width:99%;
            margin:1% 1% 0 0;
        }
        .rembtn{
            background-color: #eee;
            border: 2px solid #008CBA;
            padding: 1.5%;
            border-radius: 5px;
            transition: background-color 0.3s linear;
            cursor: pointer;
        }
        .rembtn:hover{
            background-color: #008CBA;
            transition: background-color 0.3s linear;
        }
        .checkout{
            background-color:green;
            border-radius:5px;
            margin:10px;
            float:right;
            padding:10px;
            color:#fff;
            text-decoration:none;
        }
        .empty-basket{
            background-color:grey;
            border-radius:5px;
            margin:10px;
            float:right;
            padding:10px;
            color:#fff;
            text-decoration:none;
        }
        .coupon{
            margin-left: 1%;
        }
        .coupon input{
            border-radius: 5px;
            border: 1px solid #eee;
        }
        .coupon button{
            background-color: #eee; 
            transition: background-color 0.3s linear;
            border: 1px solid #008CBA;
            padding: 1.5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .coupon button:hover{
            background-color: #008CBA;
            transition: background-color 0.3s linear;
        }
    </style>
    
</head>
<body>
<?php 
    if ($_SESSION['login'] == "true") {
        include 'navlogin.php';
    }
    else{
        include 'nav.php';
    }
    if(isset($_SESSION["shopping_cart"])){
        $total_price = 0;
    ?>	
    <div class="grid-container">
        <div class="grid-item-header"><p>ITEM IMAGE</p></div>
        <div class="grid-item-header"><p>ITEM NAME</p></div>
        <div class="grid-item-header"><p>QUANTITY</p></div>
        <div class="grid-item-header"><p>UNIT PRICE</p></div>
        <div class="grid-item-header"><p>ITEMS TOTAL</p></div>
        <div class="grid-item-header"><p>REMOVE</p></div>
   	
    <?php		
    foreach ($_SESSION["shopping_cart"] as $product){
    ?>
    
        <div class="grid-item">
            <img src='<?php echo $product["product_image"]; ?>' width="70" />
        </div>
        <div class="grid-item">
            <?php echo $product["product_name"]; ?>
        </div>
        <div class="grid-item">
            <form method='post' action=''>
            <input type='hidden' name='product_id' value="<?php echo $product["product_id"]; ?>" />
            <input type='hidden' name='action' value="change" />
            <select name='product_quantity' class='quantity' onChange="this.form.submit()">
            <option <?php if($product["product_quantity"]==1) echo "selected";?>
            value="1">1</option>
            <option <?php if($product["product_quantity"]==2) echo "selected";?>
            value="2">2</option>
            <option <?php if($product["product_quantity"]==3) echo "selected";?>
            value="3">3</option>
            <option <?php if($product["product_quantity"]==4) echo "selected";?>
            value="4">4</option>
            <option <?php if($product["product_quantity"]==5) echo "selected";?>
            value="5">5</option>
            </select>
            </form>
        </div>
        <div class="grid-item"><?php echo "£".number_format($product["product_price"],2); ?></div>
        <div class="grid-item"><?php $product_total = $product["product_price"] *$product["product_quantity"]; echo "£ ".number_format($product_total, 2) ?></div>
        <div class="grid-item">
            <form method='post' action=''>
                <input type='hidden' name='product_id' value="<?php echo $product["product_id"]; ?>" />
                <input type='hidden' name='action' value="remove" />
                <button class="rembtn" type='submit' class='remove'>Remove Item</button>
            </form>
        </div>
    
    <?php
    include_once 'config/db_connection.php';
        $total_price += ($product["product_price"]*$product["product_quantity"]);
        }
        if(isset($_POST['coupon'])){
            $coupon_code = $_POST['coupon'];
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //We search for the product that has been clicked on
                $sql = $conn->prepare('SELECT * FROM discount_codes WHERE coupon_code= :coupon_code');
                $sql -> execute(['coupon_code' => $coupon_code]); //execute the statement
                $row = $sql->fetch();
                
                $coupon_id = $row['coupon_id'];
                $discount_value = $row['coupon_discount_amount'];
                $coupon_redeemed_total = $row['coupon_redeemed_total'];
                $coupon_max_use = $row['coupon_max_use'];
                $code_used = false;
                
                if ($coupon_redeemed_total == $coupon_max_use){
                    throw new PDOException('<script>alert("Invalid Coupon!")</script>');
                }
                else{
                    $user_id = $_SESSION['id'];
                    $conn0 = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                    $conn0->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql0 = $conn0->prepare('SELECT * FROM used_codes WHERE coupon_id= :coupon_id AND user_id = :user_id');
                    $sql0 -> execute(['coupon_id' => $coupon_id, 'user_id' => $user_id]); //execute the statement
                    
                    if ($sql0->rowCount() > 0){
                        throw new PDOException('<script>alert("Invalid Coupon!")</script>');
                    }
                    else{
                        echo "<script>alert('Coupon Applied! - Discount: £$discount_value')</script>";
                        $coupon_redeemed_total += 1;
                    }
                }

                $conn2 = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
                $sql2 = $conn2->prepare('UPDATE discount_codes SET coupon_redeemed_total = :coupon_redeemed_total WHERE coupon_id = :coupon_id');
                $sql2 -> execute(['coupon_redeemed_total' => $coupon_redeemed_total,'coupon_id' => $coupon_id]);

                $total_price -= $discount_value;

                $_SESSION['$total_price'] = $total_price;
                $_SESSION['coupon_code'] = $coupon_code;
                $_SESSION['coupon_id'] = $coupon_id;
                    
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        $_SESSION['$total_price'] = $total_price;
    ?>
   </div>
    <p class="total-text">TOTAL: <?php echo "£".$total_price; ?></p>
    <div class="coupon">
        <form action="cart.php" method="post">
            <label>Discount Code:</label>
            <input type="text" name="coupon">
            <button id="coupon" type="submit">Apply</button>
        </form>
    </div>
    <a class="checkout" href="add_to_order.php"> Checkout</a>
    <a class="empty-basket" href="empty_basket.php"> Empty your basket</a>
    
    
		
<?php
    }else{
        echo "<h3 style='margin-left: 1%;' >Your cart is empty!</h3>";
        }
?>
</div>
 
<div style="clear:both;"></div>
 
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>


</body>
</html>