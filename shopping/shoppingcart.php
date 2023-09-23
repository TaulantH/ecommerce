<?php
session_start();

if (!isset($_SESSION["user"])) {
    // Redirect to a login page if the user is not logged in
    header("Location: ../login.php");
    exit();
}

require_once "../db_connect.php";
require_once "../userSession.php";

$userId = $_SESSION["user"];

$query = "SELECT user_carts.*, products.name, products.price, products.picture, discounts.discount
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
    $productImage = $row['picture'];
}

$getorders = "SELECT
products.ID AS ID,
products.name,
orders.quantity,
products.price,
purchases.purchase_date,
purchases.id AS purchase_id
FROM
orders
JOIN
products ON orders.fk_product = products.ID
JOIN
purchases ON purchases.id = orders.fk_purchase
WHERE
purchases.user_id = 6
ORDER BY
purchases.id DESC";

$ordersResults = $connect->query($getorders);

$orders = "";
$currentPurchaseId = null; // Track the current purchase ID
$rank = $orderCount = $o = 0;
if(mysqli_num_rows($ordersResults) > 0){
   
    while($row = $ordersResults->fetch_assoc()){
        // If a new purchase ID is encountered, start a new <div>
        if ($row['purchase_id'] !== $currentPurchaseId) {
            if ($currentPurchaseId !== null) {
                $orders .= "</div>"; // Close the previous <div>
            }
            $currentPurchaseId = $row['purchase_id'];
            $o ++;
            $rank = $orderCount - $o + 1;

            $orders .= "<div class='orderContainer'><div class='header d-flex justify-content-between'>
                <h5>Order #{$row['purchase_id']}</h5><span>Ordered on: {$row['purchase_date']}</span>
            </div>";
        }

        $orders .= "<div class=''>
                        
                        <div class='px-3'>
                            <p class='fw-bold fs-4'>{$row['name']}</p>
                            <div class='d-flex justify-content-between '>
                                <p><span class='fw-bold'>Price: </span>€ {$row['price']}</p>
                                <p><span class='fw-bold'>Quantity: </span> {$row['quantity']} </p>
                            
                            </div>
                        </div>
                        <div class='d-flex flex-column flex-md-row align-items-center justify-content-between p-3'>
                            <a href='../details.php?id={$row['ID']}' class='detailsBtn'>Details</a>
                            <button onclick='addToCart({$row['ID']})' class='buyBtn'>Order again</button>
                        </div>
                    </div>";
    }
    $orders .= "</div>"; // Close the last <div>
}else{
    $orders = "<p>You do not have any previous orders</p>";
}





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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
        
        a{
            text-decoration: none;
        }
        body{
            background-color: #FFFCF2;
        }
        .containerCart{
            margin: 80px auto;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        .cartInfo{
            display: flex;
            flex-wrap: wrap;
        }
        th{
            text-align: left;
            padding: 5px;
            color: #FFFCF2;
            background-color: #EB5E28;
            font-weight: normal;
        }
        td{
            padding: 10px 5px;
        }
        td p{
            margin-bottom: 0;
        }
        td a{
            color: #EB5E28;
            font-size: 12px;
        }
        td img{
            width: 80px;
            height: 80px;
            margin-right: 10px;
        }
        .totalPrice{
            display: flex;
            justify-content: flex-end;
        }
        .totalPrice table{
            border-top: 3px solid #EB5E28;
            width: 100%;
            max-width: 350px;
        }
        td:last-child{
            text-align: right
        }
        th:last-child{
            text-align: right
        }
        .buyBtn{
            width: 100%;
            max-width: 350px;
            float: right;
            background-color: #EB5E28;
            border:none;
            border-radius: 2px;
            height: 2rem;
            color: #FFFCF2;
        }
        .buyBtn:hover{
            background-color: rgba(235, 94, 40, 0.7);
            transition: 0.5s;
        }
        .buy{
            display: flex;
            justify-content: flex-end;
        }
        .orderContainer {
            border: 2px solid #252422; 
            margin-top: 1%;
            padding: 20px;
        }
        .orderContainer .header {
            background-color: #252422; 
            color: white; 
            padding: 10px;
            margin-top: 0; 
        }
        .header h5{
            margin: 0;
        }
        .detailsBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 350px;
            text-align: center;
            color: white;
            background-color: black;
            border: none;
            height: 2rem;
        }

        
</style>
</head>
<body>
<?php include_once "../components/navbar.php"
?>  

    <div class="container containerCart">
        <h2 class="text-center mb-5">Your Shopping Cart</h2>
        <?php if (empty($cartProductData)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($cartProductData as $product): ?>
                 <tr>
                    <td>
                        <div class="cartInfo">
                            <!-- right picture path? -->
                            <img src="../pictures/<?= $product['picture'] ?>" alt="<?= $product['name'] ?>">
                            <div>
                                <a href="./details.php?id=<?= $product["product_id"] ?>">
                                    <p><?= $product["name"] ?></p>
                                </a>
                                <small><?php //Calculate the discounted price
                                        $discountedPrice = $product["price"] * (1 - ($product["discount"] / 100));
                                        echo "Price: € " . number_format($discountedPrice, 2);?>
                                </small><br>
                                <a href="remove_from_cart.php?id=<?= $product["product_id"] ?>">Remove</a>

                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="btn btn-dark btn-sm decreaseButton" data-productID="<?= $product['product_id']?>">-</span>
                        <span data-productID=<?= $product['product_id']?> class="quantity"><?= $product["quantity"] ?></span>
                        <span class="btn btn-dark btn-sm incrementButton" data-productID="<?= $product['product_id']?>">+</span>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <div>
                                <span class="price" data-productID="<?= $product['product_id'] ?>">
                                    €
                                    <span><?= number_format($discountedPrice * $product["quantity"], 2) ?> </span>
                                </span>
                            </div>
                            <a href="checkout.php?product_id=<?= $product["product_id"] ?>">Buy now</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="totalPrice">
                <table>
                    <tr>
                        <td>
                            Total
                        </td>
                        <td>
                            <div id=total>
                                <?php
                            // Calculate the grand total
                            $grandTotal = 0;
                            foreach ($cartProductData as $product) {
                                $discountedPrice = $product["price"] * (1 - ($product["discount"] / 100));
                                $productTotal = $discountedPrice * $product["quantity"];
                                $grandTotal += $productTotal;
                            }
                            
                            // Display the grand total
                            echo "€ " . number_format($grandTotal, 2);
                            ?>
                           
                            </div>
                            
                        </td>
                    </tr>
                </table>
            </div>

        <?php endif; ?>
        
        <?php if(count($cartProductData) > 0): ?>
            <!-- <div class="buy"> -->
                <a href="checkout.php"><button class="buyBtn">Buy all</button></a>
            <!-- </div> -->
        <?php endif ?>
        
        </div>
        <div class="container">
            <h2 class="text-center">Previous Orders</h2>
        <?= $orders ?>
    </div>
    <?php include_once "../components/footer.php" ?>
    <script>
        function addToCart(productId) {
            console.log('Adding product to cart:', productId);

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);

                if (data.success) {
                Swal.fire({
                    icon: 'success',
                    // title: 'Oops...',
                    text: 'Product successfully added to the cart',
                    confirmButtonColor: '#EB5E28',
                })
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    confirmButtonColor: '#EB5E28',
                    })
                
            }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".incrementButton").click(function() {
                let productid = $(this).data("productid");
                $.ajax({
                    type: "POST",
                    data: { productid: productid,
                    method:"add"},
                    url: "update_quantity.php", 
                    success: function(response) {
                        console.log(response);
                        let parsedResponse = JSON.parse(response);
                        let quantity = parsedResponse.quantity;
                        let totalPrice = parsedResponse.price;
                        $(".quantity[data-productid='"+ productid + "']").text(quantity);
                        let price = quantity * totalPrice;
                        const formattedCurrency = price.toLocaleString('de-AT', {
                            style: 'currency',
                            currency: 'EUR'
                        });
                        $(".price[data-productid='"+ productid + "']").text(formattedCurrency); 
                        recalculateGrandTotal();
                    }
                });
            });
            $(".decreaseButton").click(function() {
                let productid = $(this).data("productid");
                $.ajax({
                    type: "POST",
                    data: { productid: productid,
                    method:"decrease"},
                    url: "update_quantity.php", 
                    success: function(response) {
                        let parsedResponse = JSON.parse(response);
                        let quantity = parsedResponse.quantity;
                        let totalPrice = parsedResponse.price;
                        if(quantity < 1){
                            window.location.replace("remove_from_cart.php?id="+ productid);
                        }
                        $(".quantity[data-productid='"+ productid + "']").text(quantity);
                        let price = quantity * totalPrice;
                        const formattedCurrency = price.toLocaleString('de-AT', {
                            style: 'currency',
                            currency: 'EUR'
                        });
                        $(".price[data-productid='"+ productid + "']").text(formattedCurrency); 
                        recalculateGrandTotal();
                    }
                });
            });
            // Function to recalculate the grand total using AJAX
            function recalculateGrandTotal() {
                $.ajax({
                    type: "POST",
                    url: "recalculate_total.php", // Create this PHP file
                    success: function(response) {
                        const formattedCurrency = response.toLocaleString('de-AT', {
                            style: 'currency',
                            currency: 'EUR'
                        });
                        document.getElementById('total').innerHTML = "€ " + formattedCurrency;
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });

    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
