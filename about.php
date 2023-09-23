<?php
    session_start();
    require_once "db_connect.php";
    require_once "userSession.php";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        /* about style  */

        body {
            background-color: #FFFCF2;
        }
        .about-box {
            background-color: #403D39;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .about-box h2 {
            color: #EB5E28;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .about-box p {
            color: #FFFCF2;
        }

        .about-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px; 
        }

        .btn {
            background-color: #EB5E28 !important;
            border: none;
        }

        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include_once "components/navbar.php"
    ?>
    

    <div class="container my-4">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="about-box">
                    <h2>About Us</h2>
                    <p>Welcome to StyleSpot, your ultimate destination for fashionable and trendy clothing! At ShopX, we believe that style is a reflection of your individuality, and we're here to help you express yourself through our curated collection of clothing.</p>
                    <p>Founded in 2023, ShopX started as a small passion project with a mission to provide high-quality, stylish clothing at affordable prices. Over the years, our commitment to quality and customer satisfaction has helped us grow into a leading online fashion retailer.</p>
                    <p>Our vision is to empower people to feel confident and comfortable in what they wear. We aim to be more than just a clothing store - we want to be a source of inspiration for your personal style journey.</p>
                    <p>If you have any questions, feedback, or suggestions, feel free to get in touch with us. We're here to make your shopping experience amazing!</p>
                    <p>Email: info@shopx.com</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 mt-3 d-flex flex-column">
                <img src="https://cdn.pixabay.com/photo/2022/03/25/01/15/online-shop-7090105_1280.png" alt="ShopX Image" class="about-image">
                <a class="btn btn-success mt-4" href="product.php">Our Products</a>
            </div>
        </div>
    </div>
    
    <div class="mt-5">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d170128.87925031077!2d16.215247800673357!3d48.220795893849555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476d079e5136ca9f%3A0xfdc2e58a51a25b46!2sVienna%2C%20Austria!5e0!3m2!1sen!2s!4v1692702655894!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>    </div>
    </div>


    <?php include_once "components/footer.php"
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
