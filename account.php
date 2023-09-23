<?php
session_start();

require_once "db_connect.php";
require_once "userSession.php";
require_once "file_upload.php";

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo "Query Error: " . mysqli_error($connect);
        exit();
    }

    $row = mysqli_fetch_assoc($result);
} else {
    echo "User ID not provided.";
    exit();
}
// Retrieve order history data
// Retrieve order history with associated product information
// Retrieve purchase history with associated product information
$purchaseHistoryQuery = "SELECT
    p.name as product_name,
    p.price,
    o.quantity,
    pc.total_amount,
    pc.purchase_date
FROM
    orders o
JOIN
    products p ON p.ID = o.fk_product
JOIN
    purchases pc ON pc.ID = o.fk_purchase
WHERE
    o.fk_user = $id";






$purchaseHistoryResult = mysqli_query($connect, $purchaseHistoryQuery);

if (!$purchaseHistoryResult) {
    echo "Query Error: " . mysqli_error($connect);
    exit();
}

$backBtn = "index.php";

if (isset($_SESSION["adm"])) {
    $backBtn = "dashboard.php";
}

if (isset($_POST["sign-up"])) {
    $fname = cleanInput($_POST["first_name"]);
    $lname = cleanInput($_POST["last_name"]);
    $email = cleanInput($_POST["email"]);
    $username = cleanInput($_POST["username"]);
    $date_of_birth = cleanInput($_POST["date_of_birth"]);
    $gender = cleanInput($_POST["gender"]);
    $phone_number = $_POST["phone_number"];
    $picture = fileUpload($_FILES["picture"]);

    if ($picture !== null && $_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "avatar.png") {
            unlink("pictures/{$row["picture"]}");
        }
        $sql = "UPDATE users SET fname = '$fname', lname = '$lname', username = '$username', email = '$email', date_of_birth = '$date_of_birth', phone_number = '$phone_number', gender = '$gender', picture = '$picture[0]' WHERE id = {$id}";
    } else {
        $sql = "UPDATE users SET fname = '$fname', lname = '$lname', username = '$username', email = '$email', date_of_birth = '$date_of_birth', phone_number = '$phone_number', gender = '$gender' WHERE id = {$id}";
    }

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            User has been updated, {$picture[1]}
        </div>";
        header("refresh: 3; url=$backBtn");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Error found, {$picture[1]}
        </div>";
    }
} elseif (isset($_POST["delete-account"])) {
    // Handle account deletion here
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $deleteStatement = mysqli_prepare($connect, $deleteQuery);
    mysqli_stmt_bind_param($deleteStatement, "i", $id);

    if (mysqli_stmt_execute($deleteStatement)) {
        // If the deletion is successful, log the user out and redirect to deleted.php
        session_destroy(); // Destroy the session
        header("refresh: 2; url=login.php");
        echo "<div class='alert alert-danger' role='alert'>
        Your account is delete
    </div>"; // Redirect to a confirmation or logout page
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Error deleting account: " . mysqli_error($connect) . "
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            background-color: #FFFCF2;
        }
        nav ul li a {
    color: #FFFCF2;
    font-size: 17px;
    text-transform: uppercase;
    text-decoration: none; /* Add this line to remove the underline */
}

        .profile-card {
            background-color: #FFFFFF;
            border-radius: 15px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto;
            display: block;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-field {
            margin-bottom: 10px;
        }
        .profile-field label {
            font-weight: bold;
        }
        .profile-field span {
            color: #888888;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .update-btn {
            background-color: #EB5E28;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .update-btn:hover {
            background-color: rgba(235, 94, 40, 0.7);
        }
    </style>
</head>
<body>
    <?php include_once "components/navbar.php"
        ?>
<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-9 col-xl-7">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
            <img src="pictures/<?= $row["picture"] ?>" alt="Profile Picture" class="img-fluid img-thumbnail mt-4 mb-2"
            style="width: 150px; z-index: 1">
            <a href="update.php?id=<?= $id ?>" type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
    Edit profile
</a>


            </div>
            <div class="ms-3" style="margin-top: 130px;">

            <h5 style="color: #fff; font-weight: bold; font-size: 20px;">
    <?= $row["fname"] ?> <?= $row["lname"] ?>
</h5>
                    </div>
    </div>
    <div class="p-4 text-black" style="background-color: #f8f9fa; height:100px;" >
            
          </div>
          <div class="card-body p-4 text-black">
          <div class="mb-5">
    <p class="lead fw-normal mb-1">Purchase History</p>
    <div class="p-4" style="background-color: #f8f9fa;">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($purchaseRow = mysqli_fetch_assoc($purchaseHistoryResult)) {
                    $productName = $purchaseRow['product_name'];
                    $price = $purchaseRow['price'];
                    $quantity = $purchaseRow['quantity'];
                    $totalAmount = $purchaseRow['total_amount'];
                    $purchaseDate = $purchaseRow['purchase_date'];

                    echo "<tr>";
                    echo "<td>$productName</td>";
                    echo "<td>$price</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>$totalAmount</td>";
                    echo "<td>$purchaseDate</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
         <div class="profile-field">
                    <label>Username:</label>
                    <span><?= $row["username"] ?></span>
                </div>
                <div class="profile-field">
                    <label>Email:</label>
                    <span><?= $row["email"] ?></span>
                </div>
                <div class="profile-field">
                    <label>Date of birthday:</label>
                    <span><?= $row["date_of_birth"] ?></span>
                </div>
                <div class="profile-field">
                    <label>Phone:</label>
                    <span><?= $row["phone_number"] ?></span>
                </div>
                <div class="profile-field">
                    <label>Gender:</label>
                    <span><?= $row["gender"] ?></span>
                </div>
                <div class="profile-field">
                    <label>Role:</label>
                    <span><?= $row["role"] ?></span>
                </div>
            </div>
            <div class="btn-container">
                <a href="delete.php" type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;" onclick="return confirmDelete()">Delete Account</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </section>
        <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account?");
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </div>
</body>

</html>