<?php
    require_once "../db_connect.php";
      // check session
    session_start();

    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }
    if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
        header("Location: ../login.php");
    }
    
    $discountResults = $connect->query("SELECT discounts.ID AS ID,name,discount,c.category AS category FROM discounts JOIN categories AS c ON discounts.fk_category = c.ID");
    
    $content = "";
    
    if(mysqli_num_rows($discountResults) > 0){
        while($row = $discountResults->fetch_assoc()){
            $content .= "<tr>
                            <td>{$row['discount']}</td>
                            <td>{$row['category']}</td>
                            <td>
                                <a href='update.php?id={$row['ID']}' class='btn btn-warning btn-sm'>Update</a>
                                <a href='delete.php?id={$row['ID']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
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

        }
        .container {
            background-color: #FFFCF2;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 80%;
            border-collapse: collapse;
            background-color: #FFFCF2;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #CCC5B9;
        }
        thead td {
            font-weight: bold;
        }
        th {
            background-color: #EB5E28;
            color: #FEFAE0;
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
    <a class="create" href="../discounts/create.php">Create Discount</a>
    <table>
        <thead>
            <tr>
                <td>Amount</td>
                <td>Category</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?= $content ?>
        </tbody>
    </table>
    
</body>
</html>
