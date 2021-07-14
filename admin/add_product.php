<?php
session_start();

if(!isset($_POST['submit'])){
    echo "huh";
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Include the database configuration file
    require_once '../config/db_connection.php';

    $statusMsg = "";
    $last_id = "";
    //insert product info to product table here
    
    //To get the id of the last inserted product use $last_id = $conn->lastInsertId();
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = addslashes($_POST['product_description']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO products (product_name, product_description, product_price) VALUES ('$product_name', '$product_description', $product_price)"; // building a string with the SQL INSERT you want to run
        // use exec() because no results are returned
        $conn->exec($sql);
        $last_id = $conn->lastInsertId();
        $statusMsg .=  "New product created successfully. "; // If successful we will see this

    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
    }


    // File upload configuration
    $targetDir = "../uploads/";
    $allowTypes = array('jpg','png','jpeg','gif');

    if(!empty($_FILES['cover']['name'])){
        $fileName2 = basename($_FILES['cover']['name']);
            
        $targetFilePath2 = $targetDir . $fileName2;
        $imagefileType2 = pathinfo($targetFilePath2,PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath2)){
            try {
                $conn2 = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $targetFilePath2 = str_replace("../", "", $targetFilePath2);
                //we use the last inserted ID from the product table and the target filepath to record where the image will live
                $sql2 = "INSERT INTO product_images (product_id, img_filename, img_main) VALUES ('$last_id', '$targetFilePath2', 1)"; // building a string with the SQL INSERT you want to run
                
                // use exec() because no results are returned
                $conn2->exec($sql2);
                
            }
            catch(PDOException $e){
                echo $sql2 . "<br>" . $e->getMessage(); //If we are not successful we will see an error
            }
        }
    }
    else{
        $statusMsg = 'Please select a file to upload.';
    }

    if(!empty(array_filter($_FILES['files']['name']))){
        
        //Loop through all of the files you selected to upload
        foreach($_FILES['files']['name'] as $key=>$val){
            // File upload path
            $fileName = basename($_FILES['files']['name'][$key]);
            
            $targetFilePath = $targetDir . $fileName;
            
            // Check whether file type is valid by looking at the file extension
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                    
                //insert the filename into the SQL table product_images

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                        // set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $targetFilePath = str_replace("../", "", $targetFilePath);
                        //we use the last inserted ID from the product table and the target filepath to record where the image will live
                        $sql = "INSERT INTO product_images (product_id, img_filename, img_main) VALUES ('$last_id', '$targetFilePath', 0)"; // building a string with the SQL INSERT you want to run
                        
                        // use exec() because no results are returned
                        $conn->exec($sql);

                        echo "<script>alert('Product Added!')</script>";
                        header("refresh:0.5; url=index.php");
                        
                    }
                    catch(PDOException $e){
                        echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
                    }

                }
                else{
                    //for some reason the file may have not uploaded, such as a dropped connection, or incorrect permissions
                    $errorUpload .= "Upload error:". $_FILES['files']['error'][$key].', ';
                    echo $errorUpload;
                }
            }
            else{
                //Wrong file type
                $errorUploadType .= "Wrong file type". $_FILES['files']['name'][$key].', ';
                echo $errorUploadType;
            }
        }
    }
    else{
        $statusMsg = 'Please select a file to upload.';
    }

    $statusMsg .= "Product images added. ";

    
    // Display status message
    echo $statusMsg;
}
?>