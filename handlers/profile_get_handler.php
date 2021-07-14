<?php
    session_start();
    require_once 'config/db_connection.php';

    $id = $_SESSION['id'];

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //preparing an sql statement to search email and password for whatever the user has typed and be equal to an admin user
    $sql = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $sql -> bindValue(1, "$id"); //we bind this variable to the first ? in the sql statement
    $sql -> execute(); //execute the statement

    $row = $sql->fetch();
    $fname = $row['user_firstname'];
    $lname = $row['user_lastname'];
    $email = $row['user_email'];
    $password = $row['user_password'];
?>