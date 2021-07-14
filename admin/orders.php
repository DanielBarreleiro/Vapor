<?php
    require_once '../config/db_connection.php';
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function GetProducts($conn)
    {
        $sql = $conn->prepare("SELECT orders.order_id, orders.order_date, 
        GROUP_CONCAT(products.product_name ORDER BY orders.order_id SEPARATOR ', '), 
        GROUP_CONCAT(order_items.quantity ORDER BY orders.order_id SEPARATOR ', '), orders.order_total, users.user_firstname, users.user_lastname
        FROM orders 
        JOIN order_items ON orders.order_id = order_items.order_id 
        JOIN products ON products.product_id = order_items.product_id
        JOIN users ON users.user_id = orders.user_id
        GROUP BY orders.order_id");
        $sql -> execute();
                    
        if($sql->rowCount()) {
            while ($row = $sql->fetch()){
                    echo '<br>';
                    echo 'Order ID: ' . $row['order_id'] . '<br>';
                    echo 'Order Date: ' . $row['order_date'] . '<br>';
                    echo 'Client Name: ' . $row['user_firstname'] . " " . $row['user_lastname'] . '<br>';
                    echo 'Products: ' . $row["GROUP_CONCAT(products.product_name ORDER BY orders.order_id SEPARATOR ', ')"] . '<br>';
                    echo 'Quantity: ' . $row["GROUP_CONCAT(order_items.quantity ORDER BY orders.order_id SEPARATOR ', ')"] . '<br>';
                    echo 'Order Total: £' . $row['order_total'] . '<br><br>';
                    echo '<hr>';
                    
            }
        }
        else{
            echo '<br> No orders Found';
        }
    }

    function GetSelectedProduct($conn){
        $order_date = $_POST['order_date'];

        $sql = $conn->prepare("SELECT orders.order_id, orders.order_date, 
        GROUP_CONCAT(products.product_name ORDER BY orders.order_id SEPARATOR ', '), 
        GROUP_CONCAT(order_items.quantity ORDER BY orders.order_id SEPARATOR ', '), orders.order_total, users.user_firstname, users.user_lastname
        FROM orders 
        JOIN order_items ON orders.order_id = order_items.order_id 
        JOIN products ON products.product_id = order_items.product_id
        JOIN users ON users.user_id = orders.user_id
        WHERE order_date LIKE ?
        GROUP BY orders.order_id ");
        $sql -> bindValue(1, "%$order_date%");
        $sql -> execute();
        
        if($sql->rowCount()) {
            while ($row = $sql->fetch()){
                echo '<br>';
                    echo 'Order ID: ' . $row['order_id'] . '<br>';
                    echo 'Order Date: ' . $row['order_date'] . '<br>';
                    echo 'Client Name: ' . $row['user_firstname'] . " " . $row['user_lastname'] . '<br>';
                    echo 'Products: ' . $row["GROUP_CONCAT(products.product_name ORDER BY orders.order_id SEPARATOR ', ')"] . '<br>';
                    echo 'Quantity: ' . $row["GROUP_CONCAT(order_items.quantity ORDER BY orders.order_id SEPARATOR ', ')"] . '<br>';
                    echo 'Order Total: £' . $row['order_total'] . '<br><br>';
                    echo '<hr>';
                    
            }
        }
        else{
            echo '<br> No orders Found'; //message to display if the search returned no results
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
        <form action="orders.php" method="post">
            <label>Search Orders:</label>
            <input type="date" name="order_date" id="">
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