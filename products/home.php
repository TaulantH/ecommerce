<?php 

    session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION['adm'])){ // if a session "user" is exist and have a value
        header("Location: login.php"); // redirect the user to the home page
    }

    if(isset($_SESSION["user"])){ // if a session "user" is exist and have a value
        header("Location: ../index.php"); // redirect the user to index page
    } 

    require_once "../db_connect.php";
     //clean inputs
     function cleanInput($input){ 
        $data = trim($input); 
        $data = strip_tags($data);
        $data = htmlspecialchars($data); 
        return $data;
     }

    // display all products
    $resultProducts = $connect->query("SELECT
    p.ID,
    p.name AS productName,
    p.price,
    p.picture,
    c.category,
    d.discount,
    d.name AS discountName
    FROM
    products AS p
    JOIN
    categories AS c ON p.fk_category = c.ID
    LEFT JOIN
    discounts AS d ON p.fk_category = d.fk_category
    ORDER BY
    p.ID;

    ");

    $content = "";
    if(mysqli_num_rows($resultProducts) > 0){
        while($row = $resultProducts->fetch_assoc()){
            
           if($row['discount'] != null){
                $newPrice = (1 - $row['discount'] / 100) * $row['price'];
                $price = "<div class='d-flex justify-content-between'>
                            <p class='text-decoration-line-through'><s>Old Price: {$row['price']}€</s></p>
                            <p><b>New Price: {$newPrice}€</b></p>
                        </div>";
           }else{
                $price = "<p class='card-text'><b>Price: {$row['price']}€</b></p>";
           }
            $content .= "<div class='col'>
                            <div class='card p-2 shadow' style='width: 310px; height: 100%; padding: 1px; margin: 0 auto;'>
                            <img src='../pictures/{$row['picture']}' class='card-img-top' style='width: 100%; height: 300px; object-fit: cover;' alt={$row['productName']}>
                            <div class='card-body'>
                                <h5 class='card-title text-center'>{$row['productName']}</h5>
                                {$price}
                                <p class='card-text'>{$row['category']}</p>
                                <a href='details.php?id={$row['ID']}' class='btn btn-success'>Show details</a>
                                <a href='update.php?id={$row['ID']}' class='btn btn-warning'>Edit</a>
                                <a href='delete.php?id={$row['ID']}' class='btn btn-danger'>Delete</a>
                            </div>
                        </div>
                        </div>";
        }
    }
    // group by category
    $getCategories = "SELECT * FROM categories";
    $resultCategories = $connect->query($getCategories);
    $category = $categoryError = "";
    $error = false;
    if(isset($_POST['searchCategory'])){
        $category = $categoryError = "";
        $category = cleanInput($_POST['category']);

        if($category == 0){
            $error = true;
            $categoryError = "No category choosen";
        }

        if(!$error){
             $resultProducts = $connect->query("SELECT products.ID, products.name AS productName, price, picture, c.category, d.discount, d.name AS discountName 
            FROM products 
            JOIN categories AS c ON products.fk_category = c.ID 
            JOIN discounts AS d ON c.ID = d.fk_category WHERE products.fk_category = $category;
            ");

            $content = "";
            if(mysqli_num_rows($resultProducts) > 0){
                while($row = $resultProducts->fetch_assoc()){
                    
                if($row['discount'] != null){
                        $newPrice = (1 - $row['discount'] / 100) * $row['price'];
                        $price = "<div class='d-flex justify-content-between'>
                                    <p class='text-decoration-line-through'><s>Old Price: {$row['price']}€</s></p>
                                    <p><b>New Price: {$newPrice}€</b></p>
                                </div>";
                }else{
                        $price = "<p class='card-text'><b>Price: {$row['price']}€</b></p>";
                }
                    $content .= "<div class='card p-2 shadow' style='width: 18rem;'>
                                    <img src='../pictures/{$row['picture']}' class='card-img-top' alt={$row['productName']}>
                                    <div class='card-body'>
                                        <h5 class='card-title text-center'>{$row['productName']}</h5>
                                        {$price}
                                        <p class='card-text'>{$row['category']}</p>
                                        
                                        <a href='details.php?id={$row['ID']}' class='btn btn-success'>Show details</a>
                                        <a href='update.php?id={$row['ID']}' class='btn btn-warning'>Edit</a>
                                        <a href='delete.php?id={$row['ID']}' class='btn btn-danger'>Delete</a>
                                    </div>
                                </div>";
                }
            }
        }
       
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "../brand.php"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        *{
            padding: 0;
            margin: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        body{
            background-color: #FFFCF2;
        }
    </style>
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
    <div class="container pt-5">
        <div class="d-flex justify-content-evenly">
            <a href="create.php" class="btn btn-dark">Create Product</a>
            <a href="sales_statistics.php" class="btn btn-dark">View Sales Statistics</a>
            <a href="../discounts/create.php" class="btn btn-dark">Create Discount</a>
        </div>
    <form method="POST">
       <div class="form-group pt-3 pb-3">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control" required>
                <option value="0" selected>Choose a category</option>
                <?php 
                    while($categoryRow = $resultCategories->fetch_assoc()){
                        $categoryId = $categoryRow["ID"]; 
                        $selected = ($category == $categoryId) ? 'selected' : '';
                        echo '<option value="' . $categoryId . '" ' . $selected . '>' . $categoryRow["category"] . '</option>';
                    }
                ?>
            </select>
            <span class="text-danger"><?= $categoryError ?></span>
        </div>
        <button type="submit" class="btn btn-dark pt" name="searchCategory">Search</button>
    </form>
    <form method="POST">
        <div class="mt-2 mb-4">
        <button type="submit" class="btn btn-secondary" name="showAll">Show all Products</button>
        </div>
    </form>
    <div class="container text-center">
    <div class="row g-2 g-lg-3">    
        <?= $content ?>
        </div>
    </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
