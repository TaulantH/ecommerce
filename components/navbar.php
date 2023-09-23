<?php
    if(isset($_SESSION['user']) || isset($_SESSION['adm'])){
        $log = "<a href='//{$_SERVER['HTTP_HOST']}/logout.php?logout'>Logout</a>";
        if(isset($_SESSION['user'])){
            $account = "<li><a href='//{$_SERVER['HTTP_HOST']}/account.php?id={$_SESSION['user']}'>Account</a></li>";
        }else{
            $account = "<li><a href='//{$_SERVER['HTTP_HOST']}/account.php?id={$_SESSION['adm']}'>Account</a></li>";
        }
        

    }else{
        $log = "<a href='//{$_SERVER['HTTP_HOST']}/login.php'>Log in</a>";
        $account = "";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Navbar</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        *{
            padding: 0;
            margin: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        nav{
            background: linear-gradient(#252422, #403D39 );
            height: 80px;
            width: 100%;
            border-bottom: 2px solid #EB5E28;
            position: sticky;
            top: 0;
            z-index: 100; 
        }


        label.logo{
            color: #FFFCF2;
            font-size: 35px;
            line-height:80px;
            padding: 0 100px;
            font-weight: bold;
        }

        nav ul{
            float: right;
            margin-right: 100px;
 
        }

        nav ul li{
            display: inline-block;
            line-height:80px;
            margin: 0px 10px;
        }

        nav ul li a {
            color: #FFFCF2;
            font-size: 17px;
            text-transform: uppercase;
        }

        a:hover{
            color: #CCC5B9;
            transition: 0s;
            cursor: pointer;
            border-bottom: 1px solid #EB5E28;
        }
        .checkBtn{
            font-size: 30px;
            color: #FFFCF2;
            float: right;
            line-height: 80px;
            margin-right: 40px;
            cursor: pointer;
            display: none;
        }
        #check{
            display: none;
        }
        @media (max-width: 992px){
            label.logo{
                font-size: 30px;
                padding-left: 50px;
            }
            nav ul li a{
                font-size: 16px;
            }
           nav{
            position:sticky;
            top: 0;
            z-index: 10;
           }
        }
        @media (max-width: 992px){
            .checkBtn{
                display: block;
            }
            
            nav ul{
                position: fixed;
                width: 100%;
                height: 100vh;
                background: #CCC5B9;
                top: 80px;
                left: -100%;
                text-align: center;
                transition: all .5s;
                z-index: 10;
            }
            nav ul li{
                display: block;
                margin: 50px 0;
                line-height: 30px;
                
            }
            nav ul li a{
                font-size: 20px;
                color: #252422;

            }
            .checkBtn{
                color: #CCC5B9;
            }
            a:hover{
                color: rgba(64, 61, 57, 0.7)
            }
            #check:checked ~ ul{
                left: 0%;
            }
            .fixed{
                position:fixed;
                top:0;
                z-index: 10;
            }
        }
        /*  */
    </style>
</head>
<body>
    <nav>
        
        <input type="checkbox" id="check">
        <label for="check" class="checkBtn">
            <i class="fa-solid fa-bars"></i>
        </label>
        <label class="logo">StyleSpot</label>
        <ul>
            <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/index.php">Home</a></li>
            <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/product.php">Products</a></li>
            <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/about.php">About</a></li>
            <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/contact.php">Contact</a></li>
            <?= $account ?>
            
            <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/shopping/shoppingcart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><?= $log ?> </li>
        </ul>
    </nav>
    <script>
       document.addEventListener('DOMContentLoaded', function(){
    var check = document.getElementById('check');
    var navbar = document.getElementsByTagName('nav')[0]; // Added [0] to select the first 'nav' element

    check.addEventListener('click', function(){
        navbar.classList.add('fixed');
    });
});

        </script>
</body>
</html>
