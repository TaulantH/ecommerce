<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");

    exit();
}
$userID = $_SESSION['user'];

require_once "../db_connect.php";

$productid = $_POST['productid'];

$method = $_POST['method'];

if($method == "add"){
    $sql = "UPDATE user_carts SET quantity = quantity + 1 WHERE product_id = $productid AND user_carts.user_id = $userID";
}elseif($method == "decrease"){
    $sql = "UPDATE user_carts SET quantity = quantity - 1 WHERE product_id = $productid AND user_carts.user_id = $userID";
}

if($connect->query($sql)){
    $result = $connect->query("SELECT quantity, products.price, discounts.discount FROM user_carts JOIN products ON user_carts.product_id = products.ID LEFT JOIN discounts ON products.fk_category = discounts.fk_category WHERE product_id = $productid AND user_carts.user_id = $userID");
    $row = $result->fetch_assoc();
    $updatedQuantity = $row['quantity'];
    if($row['discount'] == null){
        $price = $row['price']; 
    }else{
        $price = round($row['price'] * (1 - $row['discount'] / 100),2);
    }
    

    $response = [
        "quantity"=> $updatedQuantity,
        "price" => $price,
    ];
    echo json_encode($response);

}else{
    echo "error";
};



?>
