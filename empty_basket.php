<?php
    session_start();
    unset($_SESSION["shopping_cart"]);
    unset($_SESSION['$total_price']);
    header( "refresh:1; url=index.php" );
?>