<?php
session_start();
require_once "db_connect.php";
require_once "userSession.php";
    

if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
    exit(); // Stop further execution
}

// if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
//     header("Location: login.php");
//     exit(); // Stop further execution
// }

require_once "db_connect.php";
require_once "file_upload.php";

// Check for database connection error
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0; // Ensure it's an integer

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["user"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check for query error
if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

$row = mysqli_fetch_assoc($result);

// Update the SQL query to filter products based on the search term and category
$sqlProducts = "SELECT products.ID, products.name AS productName, price, picture, c.category, d.discount, d.name AS discountName 
                FROM products 
                JOIN categories AS c ON products.fk_category = c.ID 
                LEFT JOIN discounts AS d ON c.ID = d.fk_category
                WHERE products.display = 1 AND products.name LIKE '%$searchTerm%'";

if ($categoryFilter > 0) {
    $sqlProducts .= " AND c.ID = $categoryFilter";
}

$getCategoriesQuery = "SELECT ID, category FROM categories";
$resultCategories = mysqli_query($connect, $getCategoriesQuery);

if (!$resultCategories) {
    die("Failed to fetch categories: " . mysqli_error($connect));
}

$categories = array();
while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
    $categories[$rowCategory['ID']] = $rowCategory['category'];
}

$resultProducts = mysqli_query($connect, $sqlProducts);
$cards = "";
if (mysqli_num_rows($resultProducts) > 0) {
    while ($rowProduct = mysqli_fetch_assoc($resultProducts)) {
        $price = $rowProduct['price'];

        if ($rowProduct['discount'] != null) {
            $newPrice = (1 - $rowProduct['discount'] / 100) * $price;
            $discountInfo = "
                <div>
                    <p class='mb-0'><s class='durchgestrichen'>" . number_format($price, 2) . "€</s></p>
                    <p class='mb-0'><b>" . number_format($newPrice, 2) . "€</b></p>
                    <p class='mb-0'>Discount: " . $rowProduct['discount'] . "%</p>
                </div>";
        } else {
            $discountInfo = "<p class='card-text mb-0'><b>" . number_format($price, 2) . "€</b></p>";
        }
        $cards .= "
        <div class='col d-flex justify-content-center'>
            <div class='card p-2 shadow' style='width: 16rem; height:100%;'>
                <img src='pictures/{$rowProduct['picture']}' class='card-img-top' style='width: 100%; height: 300px; object-fit: cover' alt='...'>
                <div class='card-body'>
                    <div class='d-flex justify-content-between align-items-center'>
                        <h5 class='card-title'>{$rowProduct['productName']}</h5>
                        {$discountInfo}
                    </div>
                </div>
                <a href='details.php?id={$rowProduct['ID']}'><button class='detailsBtn'>Details</button></a>
                <button onclick='addToCart({$rowProduct['ID']})' class='addToCartBtn'>Add to Cart</button>
            </div>
            </div>
        ";
    }
} else {
    $cards = "<p>No results found</p>";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        a{
            text-decoration: none;
        }
        .checkBtn{
            margin-top: 25px;
        }
        body{
            background-color: #FFFCF2;
        }
    
        .detailsBtn{
            width: 100%;
            color: white;
            background-color: black;
            border: none;
            height: 2rem;
        }
        .addToCartBtn{
            width: 100%;
            color: white;
            background-color: #EB5E28;
            border: none;
            height: 2rem;
        }
        .durchgestrichen{
            text-decoration: line-through;
        }
        .searchDiv {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
}

/* Style for the input group (Bootstrap class) */
.input-group {
    max-width: 300px; /* Adjust the width as needed */
}

/* Style for the input field */
.form-control {
    border-radius: 20px; /* Rounded corners for the input field */
}

/* Style for the search button */
.btn-dark {
    border-radius: 20px; /* Rounded corners for the button */
    background-color: #343a40; /* Dark background color */
    color: #fff; /* Text color */
}

/* Hover effect for the search button */
.btn-dark:hover {
    background-color: #23272b; /* Darken the background color on hover */
}


        </style>
</head>
<body>
    <?php include_once "components/navbar.php"?>

<h2 class='text-center mt-5' style='font-family: Georgia, Times, serif'>Our Products</h2>
<div class="searchDiv">
    <form action="" method="GET" class="search-form row align-items-center">
        <div class="col-md-6">
            <input class="form-control" type="search" placeholder="Search products..." name="search">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="0">All Categories</option>
                <?php foreach ($categories as $categoryId => $categoryName) {echo "<option value='$categoryId'>$categoryName</option>";} ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>
    </form>
</div>

<!-- Rest of your HTML code -->


<div class="container text-center">
    <div class="row g-2 g-lg-3">    
            <?php echo $cards; ?>
        </div>
    </div>
    <?php include_once "components/footer.php"?>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz' crossorigin='anonymous'></script>
    <script>
        function addToCart(productId) {
            console.log('Adding product to cart:', productId);

            fetch('shopping/add_to_cart.php', {
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
