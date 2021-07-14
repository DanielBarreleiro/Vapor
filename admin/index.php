<?php
session_start();
if ($_SESSION['alogin'] == "true") {
    require_once '../config/db_connection.php';
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    <style>body{font-family: 'Ubuntu', sans-serif; background-color: #eee; margin: 0;}</style>
    <title>Document</title>
</head>
<body>
  <style>
    nav{
        background-color: grey;
        width: 98%;
        padding: 1%;
        display: block;
        position:relative;
    }
    .logo{
        width: 10%;
        margin-right: 1%;
    }
    .nav{
        text-decoration: none;
        padding: 0.5%;
        color: black;
        border: 2px solid #008CBA;
        transition-duration: 0.4s;
        border-radius: 5px;
        position: absolute;
        margin-top: 0.6%;
        font-size: medium;
    }
    .nav:hover{
        background-color: #008CBA;
    }
    #nav2{
        margin-left: 150px;
    }
    h1{
      color: #008CBA;
      text-align: center;
    }
    hr{
      width: 50%;
      border-color: #008CBA;
    }
    .content{
      margin: 2% 36%;
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
      background-color: #fafafa;
    }
    .admindashico{
      width: 50%;
    }
    a{
      text-decoration: none;
      color: black;
    }
    p{
      margin: 5px;
    }
  </style>
  <nav>
    <img class="logo" src="../img/VaporDark.png" alt="Logo">
    <a class="nav" id="nav1" href="add_product_form.php">Add Product ➕</a>
    <a class="nav" id="nav2" href="orders.php">Orders 🔎</a>
  </nav>
  <h1>Admin Dashboard</h1>
  <hr>
  <div class="content">
    <div class="container">
      <a href="products.php">
        <img class="admindashico" src="../img/product.png" alt="">
        <p>Products</p>
        <?php 
        $num_rows = $conn->query('SELECT count(*) FROM products')->fetchColumn();
        echo "<p>$num_rows</p>";
         ?>
      </a>
    </div>
    <div class="container" id="">
      <a href="orders.php">
        <img class="admindashico" src="../img/order.png" alt="">
        <p>Orders</p>
        <?php
        $num_rows = $conn->query('SELECT count(*) FROM orders')->fetchColumn();
        echo "<p>$num_rows</p>";
         ?>
      </a>
    </div>
  </div>
</body>
</html>
<?php
}
else{
  header("Location: ../login.php");
}
?>