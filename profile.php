<?php
    include 'handlers/profile_get_handler.php';
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
    <?php
        include 'navlogin.php';
    ?>
    <script>
        var myobj = document.getElementById("prompt");
        myobj.remove();
    </script>
    <style>
        body{
            background-image: url("img/background.jpg");
            background-size: cover;
        }
        .content{
            margin: auto;
            margin-top: 1%;
            width: 15%;
            align-content: center;
            text-align: center;
            padding: 2.5%;
            background-color: #171a21ed;
            border-radius: 20px;
        }
        .zone{
            padding: 5%;
            background-color: #eee;
            border-radius: 15px;
            border: 3px solid #008CBA;
        }
        .regbtn{
            padding: 2.5% 5%;
            background-color: #008CBA;
            border: 1px solid #008CBA;
            color: #eee;
            transition: background-color 0.3s linear;
            border-radius: 5px;
            cursor: pointer;
        }
        .regbtn:hover{
            color: #008CBA;
            background-color: #eee;
            transition: background-color 0.3s linear;
        }
        input{
            border-radius: 5px;
            border: 2px solid #008CBA;
        }
    </style>
    <div class="content">
        <form action="handlers/profile_change_handler.php" method="post">
            <div class="zone">
                <p>First Name</p>
                <input type="text" name="fname" value="<?php echo $fname ?>">

                <p>Last Name</p>
                <input type="text" name="lname" value="<?php echo $lname ?>">

                <p>Email</p>
                <input type="email" name="email" value="<?php echo $email ?>">

                <input type="hidden" name="password" value="<?php echo $password ?>">

                <p></p>
                <input class="regbtn" type="submit" value="Change Profile Details">
            </div>
        </form>
    </div>
</body>
</html>