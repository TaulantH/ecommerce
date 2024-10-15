<?php
session_start();

require_once  "db_connect.php";
require_once  "file_upload.php";

$id = $_GET["id"];

$sql = "SELECT * FROM users WHERE id = $id";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

$backBtn = "index.php";

if (isset($_SESSION["adm"])) {
    $backBtn = "dashboard.php";
}

if (isset($_POST["sign-up"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
  
    $date_of_birth = $_POST["date_of_birth"];
    $phone_number = $_POST["phone_number"];
    $picture = fileUpload($_FILES["picture"]);
  
    $picture = fileUpload($_FILES["picture"]);
    if ($picture !== null && $_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "avatar.png") {
            unlink("pictures/{$row["picture"]}");
        }
        $sql = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', date_of_birth = '$date_of_birth', phone_number = '$phone_number',  picture = '$picture[0]', WHERE id = {$id}";
    } else {
        $sql = "UPDATE users SET fname = '$fname', lname = '$lname', date_of_birth = '$date_of_birth', email = '$email', phone_number = '$phone_number' WHERE id = {$id}";
    }
    if (mysqli_query($connect, $sql)) {
        echo  "<div class='alert alert-success' role='alert'>
       user has been updated, {$picture[1]}
     </div>";
        header("refresh: 3; url=$backBtn");
    } else {
        echo   "<div class='alert alert-danger' role='alert'>
       error found, {$picture[1]}
     </div>";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit profile </title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-center" style="color: white;">Edit profile </h1>

        </head>

        <body>
            <nav>

            </nav>


            <section class="vh-100 gradient-custom">
                <div class="container py-3 " style="opacity: 0.9;">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-md-4">
                                    <h3 class="mb-0 pb-2 pb-md-0 mb-md-2">Update Form</h3>
                                    <form method="post" autocomplete="off" enctype="multipart/form-data">
                                        <div class="mb-3 mt-3">
                                            <label for="fname" class="form-label">First name</label>
                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $row["fname"] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lname" class="form-label">Last name</label>
                                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?= $row["lname"] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date of birth </label>
                                            <input type="date" class="form-control" id="date" name="date_of_birth" value="<?= $row["date_of_birth"] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="picture" class="form-label">Profile picture </label>
                                            <input type="file" class="form-control" id="picture" name="picture">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address </label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $row["email"] ?> ">
</div>
<div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone number</label>
                                            <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number" value="<?= $row["phone_number"] ?> ">
</div>
                                       
                                        <button name="sign-up" type="submit" class="btn btn-warning">Update profile</button>

                                        <a href="<?= $backBtn ?>" class="btn btn-secondary">Back</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        </body>

