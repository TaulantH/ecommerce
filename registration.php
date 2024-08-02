<?php
require_once "db_connect.php";
require_once "file_upload.php";

session_start();

if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}

$error = false;

$fname = $lname = $email = $date_of_birth = $email = $gender = $phone_number = "";
$fnameError = $lnameError = $dateError = $emailError = $passError = $genderError = $phoneError = $confirmPassError = "";

function cleanInput($param)
{
    $data = trim($param);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}

if (isset($_POST["sign-up"])) {
    $fname = cleanInput($_POST["fname"]);
    $lname = cleanInput($_POST["last_name"]);
    $email = cleanInput($_POST["email"]);
    $username = cleanInput($_POST["username"]);
    $password = $_POST["password"];
    $date_of_birth = cleanInput($_POST["date_of_birth"]);
    $gender = cleanInput($_POST["gender"]);
    $phone_number = $_POST["phone_number"];
    $picture = fileUpload($_FILES["picture"]);

    if (empty($fname)) {
        $error = true;
        $fnameError = "Please, enter your first name";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "Name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "Name must contain only letters and spaces.";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "Please, enter your last name";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "Name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "Name must contain only letters and spaces.";
    }

    if (empty($date_of_birth)) {
        $error = true;
        $dateError = "Date of birth can't be empty!";
    }

    if (empty($gender)) {
        $error = true;
        $genderError = "Gender can't be empty!";
    } elseif (!in_array($gender, array("female", "male", "other"))) {
        $error = true;
        $genderError = "Invalid gender selection.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Provided Email is already in use";
        }
    }
    if (empty($username)) {
        $error = true;
        $usernameError = "Please enter a username";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $error = true;
        $usernameError = "Username can only contain letters, numbers, and underscores.";
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    } elseif (strlen($password) < 8) {
        $error = true;
        $passError = "Password must have at least 8 characters.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W).*$/', $password)) {
        $error = true;
        $passError = "Password must include at least one uppercase letter, one lowercase letter, and one special character.";
    }

    $confirm_password = $_POST["confirm_password"];

    if (empty($confirm_password)) {
        $error = true;
        $confirmPassError = "Please confirm your password.";
    } elseif ($password !== $confirm_password) {
        $error = true;
        $confirmPassError = "Passwords do not match.";
    }
    if (!$error) {
        $password = hash("sha256", $password);
        $sql = "INSERT INTO `users`(`fname`, `lname`, `username`, `password`, `email`, `date_of_birth`, `phone_number`, `gender`, `picture`)
        VALUES ('$fname', '$lname', '$username', '$password', '$email', '$date_of_birth', '$phone_number', '$gender', '$picture[0]')";



        if (mysqli_query($connect, $sql)) {
            echo "<div class='alert alert-success'>
              <p>New account has been created</p>
          </div>";
            header("refresh: 2; url=login.php");
        } else {
            echo "<div class='alert alert-danger'>
              <p>Error: Something wrong!!!</p>
          </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            background-color: #FFFCF2;
        }

        .registBg {
            background-color: #252422;
        }

        .textColor {
            color: #EB5E28 !important;
        }

        .createBtn {
            background-color: #EB5E28;
            border: none;
        }
    </style>
</head>

<body>
    <nav>

    </nav>


    <section class="vh-100 gradient-custom mt-5">
        <div class="container py-0">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card registBg text-white" style="border-radius: 1rem;">
                        <div class="card-body p-2 text-center" style="height: 100%;">
                            <h3 class="mb-0 pb-2 pb-md-0 mb-md-2 textColor">Registration</h3>
                            <form method="post" autocomplete="off" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <label for="fname" class="form-label">First name </label>
                                            <input type="text" class="form-control" id="firstame" name="fname" placeholder="First name" value="<?= $fname ?>">
                                            <span class="text-danger"><?= $fnameError ?></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <label for="fname" class="form-label">Last name </label>
                                            <input type="text" class="form-control" id="lastame" name="last_name" placeholder="Last name" value="<?= $lname ?>">
                                            <span class="text-danger"><?= $lnameError ?></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">

                                        <div class="form-outline datepicker w-100">
                                            <label for="date" class="form-label">Date of birth</label>
                                            <input type="date" class="form-control" id="date" name="date_of_birth" value="<?= $date_of_birth ?>">
                                            <span class="text-danger"><?= $dateError ?></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <h6 class="mb-2 pb-1">Gender: </h6>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="femaleGender" value="female" checked />
                                            <label class="form-check-label" for="femaleGender">Female</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="maleGender" value="male" />
                                            <label class="form-check-label" for="maleGender">Male</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="otherGender" value="other" />
                                            <label class="form-check-label" for="otherGender">Other</label>
                                        </div>

                                    </div>
                                    <div class="form-outline">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $username ?>">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div class="form-outline">
                                                <label for="email" class="form-label">Email address </label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                                                <span class="text-danger"><?= $emailError ?></span>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div class="form-outline">
                                                <label for="phone" class="form-label">Phone number </label>
                                                <input type="phone" class="form-control" id="phoneNumber" name="phone_number" placeholder="Phone number" value="<?= $phone_number ?>">
                                                <span class="text-danger"><?= $phoneError ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Add this button next to the password input field -->
                                    <!-- Password Input Field -->
                                    <!-- Password Input Field -->
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password" name="password">
                                                <span class="text-danger"><?= $passError ?></span>
                                                <!-- Show/Hide Password Button for Password -->
                                                <button type="button" id="togglePassword" class="btn btn-light btn-sm" onclick="togglePasswordVisibility('password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Confirm Password Input Field -->
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                <span class="text-danger"><?= $confirmPassError ?></span>
                                                <!-- Show/Hide Password Button for Confirm Password -->
                                                <button type="button" id="toggleConfirmPassword" class="btn btn-light btn-sm" onclick="togglePasswordVisibility('confirm_password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">

                                            <label for="picture" class="form-label">Profile picture </label>
                                            <input type="file" class="form-control" id="picture" name="picture">

                                        </div>
                                    </div>

                                    <div class="mt-4 pt-2 pb-2">

                                        <button name="sign-up" type="submit" class="btn btn-light btn-lg createBtn">Create account </button>
                                        <span class="">you have an account already? <a href="login.php" class="textColor">log in here </a></span>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePasswordVisibility(inputId) {
            var passwordField = document.getElementById(inputId);
            var toggleButton = document.getElementById("toggle" + inputId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide Password";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show Password";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>