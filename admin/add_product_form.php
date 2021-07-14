<?php
session_start();
if ($_SESSION['alogin'] == "true") {
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
    <title>Add a product</title>
</head>
<body>
    <?php include 'nav.php' ?>
    <style>
        .content{
            margin: auto;
            margin-top: 1%;
            width: 40%;
            align-content: center;
            text-align: center;
            padding: 2%;
            background-color: #171a21ed;
            border-radius: 20px;
        }
        .zone{
            padding: 3%;
            background-color: #eee;
            border-radius: 15px;
            border: 3px solid #008CBA;
        }
        .confirmbtn{
            padding: 2.5% 5%;
            background-color: #008CBA;
            border: 1px solid #008CBA;
            color: #eee;
            transition: background-color 0.3s linear;
            border-radius: 5px;
            cursor: pointer;
            font-size: large;
        }
        .confirmbtn:hover{
            color: #008CBA;
            background-color: #eee;
            transition: background-color 0.3s linear;
        }
        input, textarea{
            border-radius: 5px;
            border: 2px solid #008CBA;
        }
    </style>
    <div class="content">
        <div class="zone">
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <p>Game Title</p>
                <input type="text" name="product_name">

                <p>Game Description</p>
                <textarea name="product_description" rows="7" cols="70"></textarea>

                <p>Price</p>
                £ <input style="width: 7%;" type="text" name="product_price">

                <p>Select Game Cover to Upload:</p>
                <input type="file" name="cover" >

                <p>Select Secondary Images to Upload:</p>
                <input type="file" name="files[]" multiple >

                <p></p>
                <input class="confirmbtn" type="submit" name="submit" value="Add Product">
            </form>
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