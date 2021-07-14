<style>
    nav{
        background-color: #171a21;
        width: 98%;
        padding: 1%;
        display: block;
        position: relative;
    }
    .logo{
        width: 10%;
        margin-right: 1%;
    }
    .nav{
        text-decoration: none;
        padding: 0.5%;
        color: #c4c3bf;
        border: 2px solid #008CBA;
        transition-duration: 0.4s;
        border-radius: 5px;
        position: absolute;
        margin-top: 0.6%;
        font-size: medium;
    }
    .nav:hover{
        background-color: #c4c3bf14;
    }
    #nav1{
        margin-left: 115px;
    }
    #nav2{
        margin-left: 220px;
    }
    .prompt{
        margin-left: 1%;
        background-color: #008cbab0;
        width: fit-content;
        padding: 0.5%;
        border-radius: 10px;
    }
</style>
<nav>
    <a href="index.php">
    <img class="logo" src="img/VaporLight.png" alt="Logo">
    </a>
    <?php
        if (isset($_GET['id'])) {
            echo '<a class="nav" id="nav0" href="index.php">◀ Go Back</a>';
        }
    ?>
    <a class="nav" id="nav1" href="login.php">Login 🔐</a>
    <a class="nav" id="nav2" href="register.php">Register 📥</a>
</nav>
<h3 class="prompt" id="prompt">In order to buy games, please login.</h3>
