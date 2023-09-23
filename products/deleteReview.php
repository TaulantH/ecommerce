<?php 

    session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION['adm'])){ // if a session "user" is exist and have a value
        header("Location: login.php"); // redirect the user to the home page
    }

    if(isset($_SESSION["user"])){ // if a session "user" is exist and have a value
        header("Location: ../index.php"); // redirect the user to index page
    } 

    require_once "../db_connect.php";

    $reviewID = $_GET['reviewID'];
    $productID = $_POST['productID'];
    

    $delete = "DELETE FROM reviews WHERE id = $reviewID"; // query to delete a record from the database

   if(mysqli_query($connect, $delete)){
       header("Location: details.php?id={$productID}");
   }else {
        echo "Error";
   }
 
   mysqli_close($connect);
?>

