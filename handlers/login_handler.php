<?php
 // important function to allow session variables  
 session_start();
    require_once '../config/db_connection.php';
    
    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST') //has the user submitted the form
        {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            // save the email the user submitted from $_POST
            $email = $_POST['email'];
            // save the password the user submitted from $_POST
            $password = $_POST['password'];
            $password = md5($password);
            
            //preparing an sql statement to search email and password for whatever the user has typed and be equal to an admin user
            $sql = $conn->prepare("SELECT * FROM users WHERE `user_email` = ? AND `user_password` = ?");
            $sql -> bindValue(1, "$email"); //we bind this variable to the first ? in the sql statement
            $sql -> bindValue(2, "$password"); //we bind this value to the second ? in the sql statement
            $sql -> execute(); //execute the statement
            
            if($sql->rowCount()) { 
                //check if we have results by counting rows
                $row = $sql->fetch();
                $id = $row['user_id'];
                $user_type = $row['user_type'];
                
                $_SESSION['id'] = $id;
                    
                if ($user_type == 0) {
                    $_SESSION['login'] = "true";
                    //redirect the user to a page we want them to go to. 
                    header("Location: ../index.php");
                }
                if ($user_type == 1) {
                    $_SESSION['alogin'] = "true";
                    //redirect the user to a page we want them to go to. 
                    header("Location: ../admin/index.php");
                }
            }
            else{
                //message to display if we did not match a user
                echo("User not found!");
            }
            
        }
        else {
            //message incase someone lands on this page without first accessing the login form
            echo("There are no doughnuts here!");
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();  //If we are not successful in connecting or running the query we will see an error
    }
?>