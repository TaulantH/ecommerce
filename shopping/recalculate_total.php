<?php
require_once "../db_connect.php"; // Include necessary files
session_start();

if (!isset($_SESSION["user"])) {
    // Handle the case when the user is not logged in
    echo "User not logged in.";
    exit();
}

$userId = $_SESSION["user"];

function recalculateTotal($connect, $userId) {

    $query = "SELECT user_carts.*, products.name, products.price, discounts.discount
          FROM user_carts
          INNER JOIN products ON user_carts.product_id = products.ID
          LEFT JOIN discounts ON products.fk_category = discounts.fk_category
          WHERE user_carts.user_id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $cartProductData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $cartProductData[] = $row;
    }
    // Calculate the grand total
    $grandTotal = 0;
    foreach ($cartProductData as $product) {
        $discountedPrice = $product["price"] * (1 - ($product["discount"] / 100));
        $productTotal = number_format($discountedPrice,2) * $product["quantity"];
        $grandTotal += $productTotal;
        
    }
    
    // Display the grand total
    return number_format($grandTotal, 2);
    
}

$total = recalculateTotal($connect, $userId);
echo $total;
?>
