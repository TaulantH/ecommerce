<?php
require_once "db_connect.php";
session_start();
require_once "userSession.php";
 



// Check for database connection error
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

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

// Update the SQL query to filter products based on the search term
$sqlProducts = "SELECT products.ID, products.name AS productName, price, picture, c.category, d.discount, d.name AS discountName 
FROM products 
JOIN categories AS c ON products.fk_category = c.ID 
LEFT JOIN discounts AS d ON c.ID = d.fk_category
WHERE products.name LIKE '%$searchTerm%' AND products.display = 1";

$resultProducts = mysqli_query($connect, $sqlProducts);

$cards = "";

if (mysqli_num_rows($resultProducts) > 0) {
    while ($rowProduct = mysqli_fetch_assoc($resultProducts)) {
        if($rowProduct['discount'] != null){
            $newPrice = round((1 - $rowProduct['discount'] / 100) * $rowProduct['price'], 2);
            $price = "<div>
                        <p class='mb-0'><s class='durchgestrichen'>{$rowProduct['price']}€</s></p>
                        <p class='mb-0'><b>{$newPrice}€</b></p>
                    </div>";
       }else{
            $price = "<p class='card-text'><b>{$rowProduct['price']}€</b></p>";
       }
        $cards .= "
        <div class='col'>
        <div class='card p-2 shadow' style='width: 15rem; height: 100%; padding: 1px; margin: 0 auto;'> <!-- Added margin: 0 auto; to center horizontally -->
            <img src='pictures/{$rowProduct["picture"]}' style='width: 100%; height: 300px; object-fit: cover;' class='card-img-top' alt='...'>
            <div class='card-body text-center'> <!-- Added text-center class to center content -->
                <h5 class='card-title mb-0'>{$rowProduct["productName"]}</h5>
                {$price}
            </div>
            <a href='details.php?id={$rowProduct["ID"]}' class='text-center'> <!-- Added text-center class to center the button -->
                <button class='detailsBtn'>Details</button>
            </a>
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
    <title><?= require_once "brand.php"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        a{
            text-decoration: none;
        }
        .checkBtn{
            margin-top: 25px;
        }
        body{
            background-color: #FFFCF2;
        }
   
        .durchgestrichen{
            text-decoration: line-through;
        }
        .detailsBtn{
            width: 100%;
            color: white;
            background-color: black;
            border: none;
            height:2rem;
            
        }/* Style for the search form container */
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
    <?php include_once "components/navbar.php"
    ?>

    <?php include_once "components/hero.php"
    ?>
    
    <h2 class='text-center mt-5' style='font-family: Georgia, Times, serif'>Summer Sale up to -25%</h2>
    <div class="searchDiv">
    <form action="" method="GET" class="search-form row align-items-center">
        <div class="col-md-8">
            <input class="form-control" type="search" placeholder="Search products..." name="search">
        </div>
       
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>
    </form>
</div>
    <div class="container text-center">
    <div class="row g-2 g-lg-3">             
        
<?php echo $cards; ?>
  </div>
    </div>
    
    <?php include_once "components/footer.php"
    ?>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz' crossorigin='anonymous'></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
