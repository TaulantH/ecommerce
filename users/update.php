<?php

    session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION['adm'])){ // if a session "user" is exist and have a value
        header("Location: login.php"); // redirect the user to the home page
    }

    if(isset($_SESSION["user"])){ // if a session "user" is exist and have a value
        header("Location: ../index.php"); // redirect the user to index page
    } 

    require_once "../db_connect.php";

    $getUsers = "SELECT ID, username FROM users WHERE role = 'user' ORDER BY username";
    $userResults = $connect->query($getUsers);

    $userID = $userError ="";
    $error = false;
    $users = "";

    if(mysqli_num_rows($userResults) > 0){
        while($rowUsers = $userResults->fetch_assoc()){
            $selected = ($userID == $rowUsers['ID']) ? "selected" : "";
            $users .= "<option value='{$rowUsers['ID']}' {$selected}>{$rowUsers['username']}</option>";
        }
    }
    if(isset($_POST['makeAdm'])){
        $userID = $_POST['user'];

        if($userID == 0){
            $error = true;
            $userError = "Please choose an user";
        }
        
        if(!$error){
            $update = "UPDATE `users` SET `role`='adm' WHERE id = ?";
            $stmt = mysqli_prepare($connect, $update);
                if ($stmt) {
                    
                    mysqli_stmt_bind_param($stmt, "i", $userID);
                    $result = mysqli_stmt_execute($stmt);
                    if ($result) {
                        echo "<div class='alert alert-success' role='alert'>
                            User has been updated to Admin
                        </div>";
                        header("refresh: 3; url= index.php");
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                            Error found
                        </div>";
                    }   
                    mysqli_stmt_close($stmt);
                }
        }
    }

    $getAdmins = "SELECT ID, username FROM users WHERE role = 'adm' ORDER BY username";
    $adminResults = $connect->query($getAdmins);

    $adminID = $adminError ="";
    $error = false;
    $admins = "";

    if(mysqli_num_rows($adminResults) > 1){
        while($rowAdmins = $adminResults->fetch_assoc()){
            $selected = ($adminID == $rowAdmins['ID']) ? "selected" : "";
            $admins .= "<option value='{$rowAdmins['ID']}' {$selected}>{$rowAdmins['username']}</option>";
        }
    }else{
        $adminError = "You are the last Admin";
    }

    if(isset($_POST['makeUser'])){
        $adminID = $_POST['admin'];

        if($userID == 0){
            $error = true;
            $userError = "Please choose an admin";
        }
        
        if(!$error){
            $update = "UPDATE `users` SET `role`='user' WHERE id = ?";
            $stmt = mysqli_prepare($connect, $update);

                if ($stmt) {
                    
                    mysqli_stmt_bind_param($stmt, "i", $adminID);
                    $result = mysqli_stmt_execute($stmt);
                    if ($result) {
                        echo "<div class='alert alert-success' role='alert'>
                            User has been updated to User
                        </div>";
                        header("refresh: 3; url= index.php");
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                            Error found
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
    <title>User Role Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Make User an Admin</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="user">Choose a user</label>
                            <select name="user" id="user" class="form-control">
                                <option value="0" selected>Choose a user</option>
                                <?= $users ?>
                            </select>
                            <span class="error"><?= $userError ?></span>
                        </div>
                        <button type="submit" name="makeAdm" class="btn btn-primary">Make Admin</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Make Admin a User</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="admin">Choose an admin</label>
                            <select name="admin" id="admin" class="form-control">
                                <option value="0" selected>Choose an admin</option>
                                <?= $admins ?>
                            </select>
                            <span class="error"><?= $adminError ?></span>
                        </div>
                        <button type="submit" name="makeUser" class="btn btn-primary">Make User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <a href="../users/index.php" class="btn btn-secondary">Back to Management</a>
    </div>
</body>
</html>
