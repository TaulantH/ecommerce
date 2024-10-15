<?php
   //check session
    

    if(isset($_SESSION['user'])){
        header("Location: ../login.php");
    }
    
    if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
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
            background-color: #FFFCF2
        }
        nav{
            background: linear-gradient(#252422, #403D39 );
            width: 100%;
            border-bottom: 2px solid #EB5E28;
            position: sticky;
            top: 0;
            z-index: 1; 
        }
        .textColor{
            color: #FFFCF2
        }
        label.logo{
            color: #FFFCF2;
            font-size: 35px;
            line-height:80px;
            padding: 0 100px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
  <label class="logo">StyleSpot</label>
    <button class="navbar-toggler" style="border:1px solid #FFFCF2; background-color: #FFFCF2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="background-color: #FFFCF2"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      
        <li class="nav-item">
          <a class="nav-link textColor" href="../dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link textColor" href="//<?php echo $_SERVER['HTTP_HOST'];?>/ecommerce/products/home.php">Go to Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link textColor" href="//<?php echo $_SERVER['HTTP_HOST'];?>/ecommerce/discounts/index.php">Go to discounts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link textColor" href="//<?php echo $_SERVER['HTTP_HOST'];?>/ecommerce/users/index.php">Manage Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link textColor" href="//<?php echo $_SERVER['HTTP_HOST'];?>/ecommerce/products/sales_statistics.php">Sales statistics</a>
        </li>
        <li class="nav-item">
          <a class="nav-link textColor" href="//<?php echo $_SERVER['HTTP_HOST'];?>/ecommerce/logout.php?logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>