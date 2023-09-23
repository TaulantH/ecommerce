<?php
session_start();

require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["product_id"])) {
        $productId = $data["product_id"];
        if(!isset($_SESSION['user'])){
            $response = array("success" => false, "message" => "Please log in first");
            echo json_encode($response);
            exit();
        }
        
        $checkAvailable = "SELECT availability FROM products WHERE ID = $productId";
        $resultAV = $connect->query($checkAvailable);
        $row = $resultAV->fetch_assoc();
        if($row['availability'] == "out of stock"){
            $response = array("success" => false, "message" => "Product is not available at the moment");
            echo json_encode($response);
            exit();
        }
        $userId = $_SESSION["user"];

        // Check if the product is already in the cart
        $checkQuery = "SELECT id FROM user_carts WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($connect, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            // Product is not in the cart, add it
            $insertQuery = "INSERT INTO user_carts (user_id, product_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($connect, $insertQuery);
            mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);
            mysqli_stmt_execute($stmt);

            // Return a success response
            $response = array("success" => true, "message" => "Product added to cart.");
            echo json_encode($response);
            exit();
        } else {
            // Product is already in the cart
            $response = array("success" => false, "message" => "Product is already in the cart.");
            echo json_encode($response);
            exit();
        }
    }
}

// If the script reaches here, it means there was an issue adding the product to the cart
$response = array("success" => false, "message" => "Failed to add product to cart.");
echo json_encode($response);
exit();
?>
