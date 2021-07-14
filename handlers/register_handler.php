<?php
    require_once '../config/db_connection.php';
    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = md5($password);
            
            $sql = $conn->prepare("INSERT INTO users(user_firstname, user_lastname, user_email, user_password, user_type) VALUES (?, ?, ?, ?, '0')");
            $sql -> bindValue(1, "$fname");
            $sql -> bindValue(2, "$lname");
            $sql -> bindValue(3, "$email");
            $sql -> bindValue(4, "$password");
            $sql -> execute();
            
            header("Location: ../login.php");
            
        }
    } 
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>