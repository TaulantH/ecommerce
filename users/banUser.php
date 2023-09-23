<?php
        session_start();

        if(!isset($_SESSION["user"]) && !isset($_SESSION['adm'])){ // if a session "user" is exist and have a value
            header("Location: login.php"); // redirect the user to the home page
        }
    
        if(isset($_SESSION["user"])){ // if a session "user" is exist and have a value
            header("Location: ../index.php"); // redirect the user to index page
        } 
    
        require_once "../db_connect.php";
        
        $urlUser = isset($_GET['id']) ? $_GET['id'] : "";


        $getUsers = "SELECT ID, username FROM users WHERE role = 'user' ORDER BY username";
        $userResults = $connect->query($getUsers);

        $userID = $expirationTime = $userError = $timeError = "";
        $error = false;
        $users = "";
        
        if(mysqli_num_rows($userResults) >0){
            while($rowUsers = $userResults->fetch_assoc()){
                $selected = ($urlUser == $rowUsers['ID'] || $userID == $rowUsers['ID']) ? "selected" : "";
                $users .= "<option value='{$rowUsers['ID']}' {$selected}>{$rowUsers['username']}</option>";
            }
        }

        
        if(isset($_POST['ban'])){
            $userID = $_POST['user'];
            $expirationTime = $_POST['expirationTime'];

            if(empty($expirationTime)){
                $error = true;
                $timeError = "Please enter an expiration time";
            }
            if($userID == 0){
                $error = true;
                $userError = "Please choose an user";
            }

            if(!$error){
                $banQuery = "INSERT INTO `banlist`(`expiration_time`, `fk_users`) VALUES (?,?)";

                $stmt = mysqli_prepare($connect, $banQuery);

                if ($stmt) {
                    
                    mysqli_stmt_bind_param($stmt, "si", $expirationTime,$userID);
                    $result = mysqli_stmt_execute($stmt);
                    if ($result) {
                        echo "<div class='alert alert-success' role='alert'>
                            User has been banned until {$expirationTime}
                        </div>";
                        header("refresh: 3; url= index.php");
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                            Error found,
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
    <title>Ban User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
    <div class="container">
        <h2>Ban User</h2>
        <form method="POST">
            <div class="form-group">
                <label for="user">Choose a user</label>
                <select name="user" id="user" class="form-control">
                    <option value="0" selected>Choose a user</option>
                    <?= $users ?>
                </select>
                <span class="error"><?= $userError ?></span>
            </div>
            <div class="form-group">
                <label for="expirationTime">Ban until</label>
                <input type="datetime-local" id="expirationTime" name="expirationTime" class="form-control" value="<?= $expirationTime ?>" required>
                <span class="error"><?= $timeError ?></span>
            </div>
            <button type="submit" name="ban" class="btn btn-primary btn-block">Ban User</button>
            <a href="../users/index.php" class="btn btn-secondary">Back to Managment</a>
        </form>

    </div>


</body>
</html>

