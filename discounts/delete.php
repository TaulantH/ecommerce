<?php
    require_once "../db_connect.php" ;
   session_start();
   if(!isset($_SESSION['adm']) && !isset($_SESSION['user'])){
        header("Location: ../login.php");
    }
    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }

   $id = $_GET["id"]; // to take the value from the parameter "id" in the url
   $delete = "DELETE FROM discounts WHERE id = $id"; // query to delete a record from the database

   if(mysqli_query($connect, $delete)){
       header( "Location: index.php");
   }else {
        echo "Error";
   }
 
   mysqli_close($connect);
?>
