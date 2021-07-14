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
    #nav1{
        margin-left: 150px;
    }
    #nav2{
        margin-left: 315px;
    }
</style>
<nav>
    <img class="logo" src="../img/VaporDark.png" alt="Logo">
    <a class="nav" id="nav0" href="index.php">Dashboard 💻</a>
    <a class="nav" id="nav1" href="add_product_form.php">Add Product ➕</a>
    <a class="nav" id="nav2" href="orders.php">Orders 🔎</a>
</nav>