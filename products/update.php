<?php
// check session
    session_start();

    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }
    if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
        header("Location: ../login.php");
    }

    //require db and file_uplod
    require_once "../db_connect.php";
    require_once "../file_upload.php";
    
    //clean inputs
    function cleanInput($input){ 
        $data = trim($input); 
        $data = strip_tags($data);
        $data = htmlspecialchars($data); 
        return $data;
     }
    // get categories for form
    $getCategories = "SELECT * FROM categories";
    $resultCategories = $connect->query($getCategories);

    // fetch data
    $productID = $_GET['id'];
    $searchProduct = "SELECT products.ID, name, price, details, fk_category, picture, availability, display FROM products JOIN categories AS c ON products.fk_category = c.ID WHERE products.ID = $productID";
    $result = $connect->query($searchProduct);
    $row = $result->fetch_assoc();
    
    // variables
    $name = $row['name'];
    $price = $row['price'];
    $details = $row['details'];
    $category = $row['fk_category'];
    
    $picture = $row['picture'];
    $availability = $row['availability'];
    $display = $row['display'];

    // define Error variables
    $nameError = $priceError = $detailsError = $categoryError = $availabilityError = $displayError = "";
    $error = false;

    // Check if the form is submitted
    if (isset($_POST['create'])) {
        // Retrieve data from the form
        $name = cleanInput($_POST["name"]);
        $price = cleanInput($_POST["price"]);
        $details = cleanInput($_POST["details"]);
        $availability = cleanInput($_POST["availability"]);
        $category = cleanInput($_POST["category"]);
        $picture = fileUpload($_FILES["picture"], "product");
        $display =isset($_POST['display']) ? 1 : 0;
        

        if(empty($name)){
            $error = true;
            $nameError = "Please, enter a name";
        }elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", $name)){
            $error = true;
            $nameError = "Name must contain only letters, numbers and spaces.";
        }
        if(empty($price)){
            $error = true;
            $priceError = "Please, enter a price";
        }elseif (!is_numeric($price) || floatval($price) <= 0) {
            $error = true;
            $priceError = "Please enter a valid amount for the price.";
        }
        if(empty($details)){
            $error = true;
            $detailsError = "Please enter some details";
        }
        if($availability == 0){
            $error = true;
            $availabilityError = "No availability choosen";
        }
        if($category == 0){
            $error = true;
            $categoryError = "No category choosen";
        }
       
        if (!$error) {

            $sql = "UPDATE `products` SET `name`= ?,`price`= ? ,`details`=?,`picture`=?,`availability`=?,`display`=?,`fk_category`=? WHERE ID = $productID";
            
            $stmt = mysqli_prepare($connect, $sql);

            if ($stmt) {
                
                mysqli_stmt_bind_param($stmt, "sdsssii", $name, $price, $details, $picture[0], $availability, $display, $category);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>
                        {$name} has been updated, {$picture[1]}
                    </div>";
                    header("refresh: 3; url= home.php");
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                        Error found, {$picture[1]}
                    </div>";
                }
                
                mysqli_stmt_close($stmt);
            }
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
<title><?= include_once "../brand.php"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<style>
        body {
            background-color: #CCC5B9;
        }
        .container {
            background-color: #FFFCF2;
            border-radius: 10px;
            padding: 30px;
            max-width: 700px;
            max-height: 800px;
            margin-top: 50px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }
        .container h2 {
            text-align: center;
        }
        .form-control {
            background-color: #CCC5B9;
            border: none;
            border-radius: 5px;
        }
        .btn-primary {
            text-align: center;
            background-color: #EB5E28;
            border: none;
            color: #FEFAE0;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #D4A373;
        }
        .alert {
            background-color: #FAEDCD;
            border: 1px solid #D4A373;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
<div class="container mt-4">
    <h2>Update Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" >
            <span class="text-danger"><?= $nameError ?></span>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $price ?>" required>
            <span class="text-danger"><?= $priceError ?></span>
        </div>
        <div class="form-group">
            <label for="details">Details:</label>
            <textarea class="form-control" id="details" name="details" required><?= $details ?></textarea>
            <span class="text-danger"><?= $detailsError ?></span>
        </div>
        <div class="form-group">
            <label for="availability">Availability:</label>
            <select class="form-control" id="availability" name="availability" required>
                <option value="0" selected>Choose Availability</option>
                <option value="available" <?php if ($availability === 'available') echo 'selected'; ?>>Available</option>
                <option value="coming soon" <?php if ($availability === 'coming soon') echo 'selected'; ?>>Comming soon</option>
                <option value="out of stock" <?php if ($availability === 'out of stock') echo 'selected'; ?>>Out of Stock</option>
            </select>
            <span class="text-danger"><?= $availabilityError ?></span>
        </div>
        <div class="form-group">
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
        <div class="form-group" >
            <label for="picture">Image</label>
            <br>
            <img src='../pictures/<?=$row['picture']?>' alt="<?= $name ?>"  class="img-thumbnail">
            <input type="file" class="form-control" id="picture" name="picture">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="display" name="display" <?= ($display == 1) ?  "checked" : "" ?>>
            <label class="form-check-label" for="display">Display</label>
        </div>

        <button type="submit" class="btn btn-warning" name="create">Update</button>
    </form>
</div>

</body>
</html>
