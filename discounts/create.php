<?php
    // check session
    session_start();

    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }
    if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
        header("Location: ../login.php");
    }

    //require db 
    require_once "../db_connect.php";
   
    
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

    // variables
 $discount = $category =  "";
    $discountError = $categoryError = "";
    $error = false;

    
    if(isset($_POST['create'])){


        $discount = cleanInput($_POST["discount"]);
        $category = cleanInput($_POST["category"]);

        // check for discounts
        $checkCategory = $connect->query("SELECT * FROM discounts WHERE fk_category = $category");

        if(empty($discount)){
            $error = true;
            $discountError = "Please, enter a discount";
        }elseif (!is_numeric($discount)) {
            $error = true;
            $discountError = "Please enter a valid amount for the discount.";
        }
        if($category == 0){
            $error = true;
            $categoryError = "No category choosen";
        }elseif(mysqli_num_rows($checkCategory) > 0){
            $error = true;
            $categoryError = "Category has already a discount. Delete the old discount first or edit the old discount";
        }

        if (!$error) {

            $sql = "INSERT INTO `discounts`( `discount`, `fk_category`, `name`) VALUES (?,?,?)";
            
            $stmt = mysqli_prepare($connect, $sql);

            if ($stmt) {
                
                mysqli_stmt_bind_param($stmt, "iis", $discount, $category, $name);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>
                        New Discount has been created, {$name}
                    </div>";
                    header("refresh: 3; url= index.php");
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                        Error found, please try again
                    </div>";
                }
                
                mysqli_stmt_close($stmt);
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
        body {
            background-color: #CCC5B9;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;

            margin: 0;
        }
        h2 {
            font-weight: bold;
            font-size: 45px;
        }
        .container {
            background-color: #FFFCF2;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #EB5E28;
            margin-bottom: 10px;
        }
        .form-control {
            background-color: #FEFAE0;
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            color: #333;
        }
        .btn-primary {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #EB5E28;
            border: none;
            color: #FEFAE0;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #D4A373;
        }
        .text-danger {
            color: #D9534F;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
<h2>Add New Discount</h2>
    <form method="POST" >

        <div class="form-group">
            <label for="discount">Discount:</label>
            <input type="number" class="form-control" id="discount" name="discount" value="<?= $discount ?>" required>
            <span class="text-danger"><?= $discountError ?></span>
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
        <button type="submit" class="btn btn-primary" name="create">Create Discount</button>
    </form>
</body>
</html>