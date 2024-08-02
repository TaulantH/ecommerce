<?php
ob_start();
session_start();
require_once "../db_connect.php"; // Include your database connection code

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit();
}


$userID = $_SESSION["user"];

if(isset($_GET['product_id'])){
    $productId = $_GET["product_id"];

     $getCart = "SELECT user_carts.*, quantity, p.name, price, discount FROM `user_carts` JOIN products AS p ON user_carts.product_id = p.ID left JOIN discounts AS d ON p.fk_category = d.fk_category WHERE user_carts.user_id = ? AND user_carts.product_id = ?";
    $stmt = mysqli_prepare($connect, $getCart);
    mysqli_stmt_bind_param($stmt, "ii", $userID,$productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    $discountedPrice = ($product['discount'] != null) ? $discountedPrice = $product['price'] - ($product['price'] * $product['discount'] / 100): $product['price'];
    $discountedPrice = number_format($discountedPrice,2);
    $discount = ($product['discount'] != null) ? "<p class='card-text'>Discount: {$product['discount']}%</p><p class='card-text'>Discounted Price: {$discountedPrice} €</p>" : "";
    $quantity = $product['quantity'];
    $totalTotal = number_format($discountedPrice * $quantity,2);
    $card = "";
    $card = "<h5 class='card-title'>{$product['name']} </h5>
            <p class='card-text'>Price: {$product['price']}€</p>
            {$discount}
            <p>Quantity: {$quantity}</p>
            <p>Total: {$totalTotal}€</p>";
}else{
    $getCart = "SELECT user_carts.*, quantity, p.name, price, discount FROM `user_carts` JOIN products AS p ON user_carts.product_id = p.ID left JOIN discounts AS d ON p.fk_category = d.fk_category WHERE user_carts.user_id = ?";
    $stmt = mysqli_prepare($connect, $getCart);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $totalTotal = 0;
    $card = "";
    while ($product = mysqli_fetch_assoc($result)) {
        $discountedPrice = $product['price']; 

        if ($product['discount'] !== null) {
            $discount = $product['discount'];
            $discountedPrice = $product['price'] * (1 - ($discount / 100));
           
        } else {
            $discountText = "";
        }

        $quantity = $product['quantity'];
        $total = $discountedPrice * $quantity;
        $totalTotal += $total;
        $card .= "<div class='checkout-item'>
        <div class='product-info'>
            <h2 class='product-title'>{$product['name']}</h2>
            <div class='price-discount'>
                <p class='quantity'>Price: {$product['price']}€</p>
                </div>
                <div class='price-discount'>
                <p class='discount'>Discount: " . number_format($product['discount'], 2) . "%</p> 
                </div>
                <div class='price-discount'>
                <p class='quantity'>Discounted Price: " . number_format($discountedPrice, 2) . "€</p>
            </div>
            <p class='quantity'>Quantity: {$quantity}</p>
        </div>
        <div class='total'>
            <p class='total-amount'>Total: " . number_format($total, 2) . "€</p>
        </div>
    </div>";


    }
}

// Fetch the user's information from the database using their session ID
$userQuery = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $userQuery);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["user"]);
mysqli_stmt_execute($stmt);
$userResult = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($userResult);

// Initialize variables to hold form input
$fullName = $address = $city = $country = $paymentMethod = $creditCard = $expiryDate = $cvv = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user information from the form
    $fullName = $_POST["full_name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $paymentMethod = $_POST["payment_method"];
    $creditCard = $_POST["credit_card"] ?? "";
    $expiryDate = $_POST["expiry_date"] ?? "";
    $cvv = $_POST["cvv"] ?? "";

 // Insert purchase information into the database
$insertQuery = "INSERT INTO purchases (user_id, full_name, address, city, country, payment_method, credit_card, expiry_date, cvv,`total_amount`, purchase_date)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $insertQuery);
mysqli_stmt_bind_param($stmt, "issssssssds", $_SESSION["user"], $fullName, $address, $city, $country, $paymentMethod, $creditCard, $expiryDate, $cvv, $totalTotal, $_POST["purchase_date"]);

// Execute the insertion query
if (mysqli_stmt_execute($stmt)) {
    // Get the ID of the newly inserted purchase
    $newPurchaseId = mysqli_insert_id($connect);
    
    // add everything to order
    if(isset($_GET['product_id'])){
        $getCart = "SELECT user_carts.*, price, discount FROM `user_carts` JOIN products AS p ON user_carts.product_id = p.ID left JOIN discounts AS d ON p.fk_category = d.fk_category WHERE user_carts.user_id = $userID AND user_carts.product_id = $productId";
    }else{
        $getCart = "SELECT user_carts.*, price, discount FROM `user_carts` JOIN products AS p ON user_carts.product_id = p.ID left JOIN discounts AS d ON p.fk_category = d.fk_category WHERE user_carts.user_id = $userID";
    }
    
    $cartResult = $connect->query($getCart);
    $products = [];
    if(mysqli_num_rows($cartResult) > 0){
        while($cartRow = $cartResult->fetch_assoc()){
            $product = $cartRow['product_id'];
            $quantity = $cartRow['quantity'];
            $products[] = $product;
            $addToOrder = "INSERT INTO `orders`(`fk_user`, `fk_product`, `quantity`, `fk_purchase`) VALUES (?,?,?,?)";
            $orderStmt = mysqli_prepare($connect, $addToOrder);
            mysqli_stmt_bind_param($orderStmt, "iiii", $userID, $product,$quantity, $newPurchaseId);
            mysqli_stmt_execute($orderStmt);
            }
        
    }

    require_once "../mail.php";

    $getPurchase = "SELECT address, city, country, products.name, quantity, price, discount  FROM orders JOIN purchases ON purchases.ID = orders.fk_purchase JOIN products ON products.ID = orders.fk_product left JOIN discounts ON products.fk_category = discounts.fk_category WHERE fk_purchase = $newPurchaseId";
    $purchaseResult = $connect->query($getPurchase);
    $productsTable = "<table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>";
    while($purchaseRow = $purchaseResult->fetch_assoc()){
        $discount = ($purchaseRow['discount'] != null) ? "<td>{$purchaseRow['discount']}%</td>" : "<td></td>";
        $totalProduct = ($purchaseRow['price'] - ($purchaseRow['price'] * $purchaseRow['discount'] / 100));
        $productsTable .= "<tr>
                                <td>{$purchaseRow['name']}</td>
                                <td>{$purchaseRow['quantity']}</td>
                                <td>{$purchaseRow['price']}</td>
                                {$discount}
                                <td>{$totalProduct} &euro;</td>
                            </tr>";
        $address = $purchaseRow['address'];
        $city = $purchaseRow['city'];
        $country =$purchaseRow['country'];
    };
    $productsTable .= "</tbod></table>";

    $searchUser = "SELECT fname, email FROM users WHERE ID = {$_SESSION['user']}";
    $userResult = $connect->query($searchUser);
    $userRow = $userResult->fetch_assoc();

    $body = "<h2>Thank you, {$userRow['fname']}</h2>
     <p>You bought: </p>
      {$productsTable}
      <p> for a grand Total of: {$totalTotal} &euro;</p>
      <p> it will be sent to </p>
      <p>{$address}, {$city}</p>
      <p> {$country} <p>";
   
    $email = sendMail($userRow['email'],$userRow['fname'],'Thank you', $body);
    // delete item after checkout
    if(isset($_GET['product_id'])){
        header("Location: remove_from_cart.php?id={$productId}");
    }else{
        header("Location: remove_from_cart.php?userID={$userID}");
    }

   
  
} else {
    // Purchase failed, display error message
    $error = "An error occurred during the purchase process.";
}
}
ob_end_flush(); // Flush the output buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "../brand.php"; ?></title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>

.form-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    appearance: none;
    background: url('dropdown-arrow.png') no-repeat right center;
    background-size: 20px;
}

/* Style for dropdown options */
.form-select option {
    padding: 10px;
    font-size: 16px;
    background-color: #fff;
    color: #333;
}

/* Apply custom styles when the dropdown is focused */
.form-select:focus {
    border-color: #D4A373;
    box-shadow: 0 0 5px rgba(212, 163, 115, 0.5);
    outline: none;
}
.checkout-item {
    display: flex;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
}
.price-discount {
    display: flex;
    align-items: center;
}

.price {
    margin-right: 10px;
}

.discount {
    color: #FF5733; /* Example color for discount */
    margin-left: 0px;
}

.quantity,
.total {
    font-weight: bold;
    margin-top: 5px;
}.checkout-item {
    display: flex;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
}

.product-info {
    flex: 1;
    padding-right: 20px;
}

.product-title {
    margin-bottom: 10px;
}

.price-discount {
    margin-bottom: 10px;
}

.price,
.discount,
.discount-price {
    margin: 5px 0;
}

.total {
    text-align: right;
}

.total-amount {
    font-size: 18px;
    font-weight: bold;
}

/* Adjust the font sizes, colors, and margins as needed */

.product-info {
    flex: 1;
    padding-right: 20px;
}

.product-title {
    margin-bottom: 10px;
}

        
    </style>
</head>
<body>
<?php include_once "../components/navbar.php"
    ?>
    <div class="container">
        <h1>Checkout</h1>
        <div class="card">
            <div class="card-body">
                <?= $card ?>
                
               <!-- Checkout Form -->
               <form id="checkout-form" action="" method="POST">
    <input type="hidden" name="purchase_date" value="<?= date('Y-m-d H:i:s') ?>"> 
    <div class="row">
    <div class="col-md-6 mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $user['fname'] . ' ' . $user['lname'] ?>" required readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="visa">Visa Card</option>
                <option value="PayPal">PayPal</option>
                <option value="MasterCard">MasterCard</option>
            </select>
        </div>


        <div class="col-md-6 mb-3">
            <label for="credit_card" class="form-label">Credit Card Number: 16 digits</label>
            <input type="text" class="form-control" id="credit_card" name="credit_card" pattern="[0-9]{16}" maxlength="16" required>
            <span id="creditCardError" class="error-text"></span> <!-- Error message container -->
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
        </div>

 
        <div class="col-md-6 mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" pattern="[0-9]{3}" maxlength="3" required>
            <span id="cvvError" class="error-text"></span> <!-- Error message container -->
        </div>
        <div class="col-md-6 mb-3">
            <!-- Additional fields for the second row can be added here if needed -->
        </div>
    </div>
    <button type="submit" style="width: 250px;" class="btn btn-outline-dark">Order</button>
</form>
            </div>
        </div>
    </div>
<!-- After the form submission PHP block -->
<!-- Display an alert if the order is confirmed -->
<script>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) : ?>
            var paymentMethod = document.getElementById("payment_method").value;
            var confirmed = false;

            // Calculate total amount based on product price and discount (if available)
            var totalAmount = <?= $product["price"] ?>;
            <?php if ($product["discount"] !== null) : ?>
                totalAmount = <?= $product["discount"] ?>;
            <?php endif; ?>

            // Check if the payment method is "Visa Card"
            if (paymentMethod === "visa") {
                // Show a confirmation dialog with the calculated total amount
                confirmed = confirm("Thank you for your order!\n\nProduct: <?= $product['name'] ?>\nTotal Amount: " + totalAmount.toFixed(2) + "€");
            }

            // If the user confirms, redirect to the shopping cart
            if (confirmed) {
                window.location.href = "shoppingcart.php"; // Modify the URL as needed
            }
        <?php endif; ?>
        document.getElementById("checkout-form").addEventListener("submit", function(event) {
        var creditCardInput = document.getElementById("credit_card");
        var cvvInput = document.getElementById("cvv");
        
        // Credit card number pattern: 16 digits
        var creditCardPattern = /^[0-9]{16}$/;
        
        // CVV pattern: 3 digits
        var cvvPattern = /^[0-9]{3}$/;

        if (!creditCardPattern.test(creditCardInput.value)) {
            alert("Please enter a valid 16-digit credit card number.");
            event.preventDefault(); // Prevent form submission
        }

        if (!cvvPattern.test(cvvInput.value)) {
            alert("Please enter a valid 3-digit CVV.");
            event.preventDefault(); // Prevent form submission
        }
    });
    </script>
</body>
</html>

