<?php
    include '../handlers/get_product_handler.php';
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
    <title>Document</title>
</head>
<body>
<?php include 'nav.php' ?>
<style>
        body{
            background-image: url("img/background.jpg");
            background-size: cover;
        }
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
        <form action="../handlers/edit_product_handler.php" method="post">
            <div class="zone">
                <img src="<?php echo "../".$main_img ?>" alt="Game Main Image" width="200">
                <p>Game Title</p>
                <input type="text" name="product_name" value="<?php echo $product_name ?>">

                <p>Game Description</p>
                <textarea name="product_description" rows="7" cols="70"><?php echo utf8_encode($product_description) ?></textarea>

                <p>Price</p>
                £ <input style="width: 7%;" type="number" name="product_price" value="<?php echo $product_price ?>">

                <p>Featured Product</p>
                <?php
                    if ($featured == 1) {
                        echo '<input type="checkbox" name="featured" checked>';
                    }
                    else{
                        echo '<input type="checkbox" name="featured">';
                    }
                ?>

                <p></p>
                <input class="confirmbtn" type="submit" value="Change Game Details">
            </div>
        </form>
    </div>
</body>
</html>