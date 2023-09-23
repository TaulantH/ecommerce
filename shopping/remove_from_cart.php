<?php
session_start();

if (!isset($_SESSION["user"])) {
    // Redirect to a login page if the user is not logged in
    header("Location: ../login.php");
    exit();
}

require_once "../db_connect.php";

if (isset($_GET["id"])) {
    $productId = $_GET["id"];
    $userId = $_SESSION["user"];

    // Delete the product from the user's cart
    $deleteQuery = "DELETE FROM user_carts WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($connect, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);
    mysqli_stmt_execute($stmt);

    header("Location: shoppingcart.php");
    exit();
}
if(isset($_GET['userID'])){
    $userId = $_SESSION["user"];
    // Delete all the product from the user's cart
    $deleteQuery = "DELETE FROM user_carts WHERE user_id = ?";
    $stmt = mysqli_prepare($connect, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    header("Location: shoppingcart.php");
    exit();
}
?>
