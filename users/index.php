<?php
    require_once "../db_connect.php";
      // check session
    session_start();

   
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;

        }
        .container {
    text-align: center;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
        }

        h1 {
            margin-bottom: 20px;
        }
        .create {
            display: block;
            width: fit-content;
            margin: 30px auto;
            padding: 30px 50px;
            background-color: #EB5E28;
            border: none;
            color: #FEFAE0;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }
        .create:hover {
            background-color: #D4A373;
        }
     
    </style>
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
    <div class="container">
        <h1>User Management</h1>
        <p>What do you want to do?</p>
        <a class="create" href="update.php">Update User</a>
        <a class="create" href="banUser.php">Ban User</a>
       
    </div>
</body>
</html>
