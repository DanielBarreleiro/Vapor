<?php
    session_start();
    require_once 'config/db_connection.php';

    $id = $_GET['id'];
    $product_id = $_GET['id'];

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //preparing an sql statement to search email and password for whatever the user has typed and be equal to an admin user
    $sql = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $sql -> bindValue(1, "$id"); //we bind this variable to the first ? in the sql statement
    $sql -> execute(); //execute the statement

    $row = $sql->fetch();
    $product_name = $row['product_name'];
    $product_description = $row['product_description'];
    $product_price = $row['product_price'];

    $sql2 = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY img_main DESC");
    $sql2 -> bindValue(1, "$id"); //we bind this variable to the first ? in the sql statement
    $sql2 -> execute(); //execute the statement

    $row = $sql2->fetch();
    $main_img = $row['img_filename'];
    $product_image = $row['img_filename'];

    $cartArray = array(
        $product_id=>array(
        'product_name'=>$product_name,
        'product_id'=>$product_id,
        'product_price'=>$product_price,
        'product_image'=>$product_image,
        'product_quantity'=>1
        )
    );

    $status = ""; //initiating the variable to use later
    if (isset($_POST['id']) && $_POST['id']!=""){
        $product_id = $_POST['id']; //For product ID to exist, someone must have pressed buy on a product
            if(empty($_SESSION["shopping_cart"])) {
                $_SESSION["shopping_cart"] = $cartArray;
                $status = "<div class='box'>Product is added to your cart!</div>";
                echo "<script>alert('Product Added to cart!')</script>";
            }else{
                $array_keys = array_keys($_SESSION["shopping_cart"]);
                if(in_array($product_id,$array_keys)) {
                $status = "<div class='box' style='color:red;'>
                Product is already added to your cart!</div>";	
                } else {
                $_SESSION["shopping_cart"] = $_SESSION["shopping_cart"] + $cartArray;
                $status = "<div class='box'>Product is added to your cart!</div>";
                echo "<script>alert('Product Added to cart!')</script>";
            }
    
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
            body, html{
                font-family: 'Ubuntu', sans-serif;
                height: 100%;
                margin: 0;
            }
            .container{
                background-color: rgba(192, 192, 192, 0.9);
                width: 75%;
                margin: auto;
                height: 80%;
                padding: 1%;
            }
            .product_image{
                margin: 5px;
            }
            .imgs{
                margin: auto;
                width: 100%;
                padding: 1%;
            }
            .details{
                margin: 1%;
            }
            .button{
                border: none;
                padding: 16px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                transition-duration: 0.4s;
                cursor: pointer;
                background-color: rgba(192, 192, 192, 0.9); 
                color: black; 
                border: 2px solid #008CBA;
                border-radius: 5px;
            }

            .button:hover {
                background-color: #008CBA;
                color: white;
            }

            .backbtn{
                height: 30px;
                width: 90px;
                border: none;
                transition-duration: 0.4s;
                background-color: black; 
                color: black; 
                border: 2px solid #008CBA;
                border-radius: 5px;
            }

            .backbtn:hover {
            background-color: #008CBA;
            color: white;
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
    ?>
    <div class="container">
        <div class="imgs">
        <img src="<?php echo $main_img ?>"class='product_image' alt="Game Main Image" height='300'>
        <?php
        while($row = $sql2->fetch()){
            echo "<img class='product_image' height='300' src='". $row['img_filename'] ."'><style> body{background-image: url(" . $row['img_filename'] ." ); height: 100%; background-position: center;
                background-repeat: no-repeat;
                background-size: cover;}</style>";
        }
        ?>
        </div>
        <div class="details">
            <h3><?php echo $product_name ?></h3>
            <p style="width: 700px;"><?php echo utf8_encode($product_description) ?></p>
            <hr style="border-color: darkgrey">
            <p style="font-weight: 700;">Price:</p>
            <span style="font-weight: 700; font-size: 200%">£<?php echo $product_price ?></span>
            <div>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <?php
                        if ($_SESSION['login'] == "true") {
                            echo "<button type='submit' class='button'>Buy Now</button>";
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>