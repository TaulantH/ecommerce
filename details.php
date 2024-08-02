<?php
session_start();
require_once "db_connect.php";
require_once "userSession.php";


$productID = $_GET['id'];
$searchProduct = "SELECT products.ID, products.name AS productName, price, details, products.fk_category, picture, availability, display, c.category as category, d.discount, d.name AS discountName FROM products LEFT JOIN categories AS c ON products.fk_category = c.ID LEFT JOIN discounts AS d ON c.ID = d.fk_category WHERE products.ID = ?";
$stmt = mysqli_prepare($connect, $searchProduct);

if (!$stmt) {
    die("Preparation failed: " . mysqli_error($connect));
}

$reviews = [];
$sqlGetReviews = "SELECT * FROM reviews WHERE product_id = ?";
$stmtGetReviews = mysqli_prepare($connect, $sqlGetReviews);

if (!$stmtGetReviews) {
    die("Preparation failed: " . mysqli_error($connect));
}

mysqli_stmt_bind_param($stmtGetReviews, "i", $productID);
mysqli_stmt_execute($stmtGetReviews);
$resultReviews = mysqli_stmt_get_result($stmtGetReviews);

while ($rowReview = mysqli_fetch_assoc($resultReviews)) {
    $reviews[] = $rowReview;
}
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = $result->fetch_assoc();

if ($row) {
    // Variables
    $id = $row['ID'];
    $name = $row['productName'];
    $price = $row['price'];
    $details = $row['details'];
    $category = $row['fk_category'];
    $categoryName = $row['category'];
    $picture = $row['picture'];
    $availability = $row['availability'];
    $display = $row['display'];

    // Check if the discount percentage is set
    if (isset($row['discount'])) {
        $discount = $row['discount'];
        $discountName = $row['discountName'];

        // Calculate price with discount
        $priceWithDiscount = $price - ($price * ($discount / 100));
    } else {
        $discount = 0;
        $discountName = "No Discount";
        $priceWithDiscount = $price; // No discount, so price remains the same
    }
} else {
    // If no product data is found, initialize variables with default values
    $id = 0;
    $name = "Product Not Found";
    $price = 0;
    $details = "";
    $category = 0;
    $categoryName = "Unknown Category";
    $picture = "default.jpg"; // Assuming you have a default image
    $availability = "Not Available";
    $display = "Unknown Display";
    $discount = 0;
    $discountName = "No Discount";
}

$userID = $_SESSION['user'];
$sqlCheckPurchase = "SELECT * FROM orders WHERE fk_user = ? AND fk_product = ?";
$stmtCheckPurchase = mysqli_prepare($connect, $sqlCheckPurchase);

if (!$stmtCheckPurchase) {
    die("Preparation failed: " . mysqli_error($connect));
}

mysqli_stmt_bind_param($stmtCheckPurchase, "ii", $userID, $id);
mysqli_stmt_execute($stmtCheckPurchase);
$resultCheckPurchase = mysqli_stmt_get_result($stmtCheckPurchase);
$canSubmitReview = mysqli_num_rows($resultCheckPurchase) > 0;

$reviewForm = ""; // Fillojme me bosh, pastaj do e ndryshojme nëse duhet

if ($canSubmitReview && !isset($_SESSION['review_submitted'])) {
    // The user has purchased the product and can submit a review
    $reviewForm = "
        <form action='submit_review.php?product_id=$id' method='POST'>
            <label for='rating'>Rating:</label>
            <select name='rating' id='rating'>
                <option value='1'>1 <span class='fa fa-star checked'></span></option>
                <option value='2'>2 <span class='fa fa-star checked'></option>
                <option value='3'>3 <span class='fa fa-star checked'></option>
                <option value='4'>4 <span class='fa fa-star checked'></option>
                <option value='5'>5 <span class='fa fa-star checked'></option>
            </select>
            <br>
            <label for='comment'>Comment:</label>
            <textarea name='comment' id='comment' rows='4' cols='40'></textarea>
            <br>
            <button type='submit' class='btn btn-primary'>Submit Review</button>
        </form>
    ";
} else {
    // The user has not purchased the product or has already submitted a review
    if (!$canSubmitReview) {
        $reviewForm = "<p>You must purchase this product to submit a review.</p>";
    }
}

if (isset($_SESSION['review_submitted']) && $_SESSION['review_submitted'] === true) {
    $reviewMessage = "<p>Your review has been submitted successfully.</p>";
    // Clear the session variable to prevent showing the message again on refresh
    unset($_SESSION['review_submitted']);
} else {
    $reviewMessage = "";
}

$previousQuestions = "";

$resultQuestion = $connect->query("SELECT * FROM questions WHERE product_id = $productID");
if (mysqli_num_rows($resultQuestion) > 0) {
    while ($questionsRow = $resultQuestion->fetch_assoc()) {
        $previousQuestions .= "<div style='background-color: #CCC5B9'>
                                <span class='fs-5 ps-1'>Q:</span> <span>{$questionsRow['question_text']}</span>
                                </div>
                                <div>
                                <span class='fs-5 ps-1'>A:</span> <span>{$questionsRow['answer']}</span>
                                </div>";
    }
}
$questionForm = "";
if ($_SESSION['user']) {
    $questionForm = " <div class='col-md-12 mt-3'>
                        <div class='accordion' id='createQuestionBox'>
                            <div class='accordion-item'>
                                <h2 class='accordion-header'>
                                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#createQuestion' aria-expanded='false' aria-controls='createQuestion'>
                                        Ask a Question
                                    </button>
                                </h2>
                                <div id='createQuestion' class='accordion-collapse collapse' data-bs-parent='#createQuestionBox'>
                                    <div class='accordion-body'>
                                        <form action='submit_question.php?product_id=$productID' method='POST'>
                                            <label for='question' class='form-label'>Question:</label>
                                            <textarea name='question_text' id='question' rows='4' cols='50' class='form-control'></textarea>
                                            <br>
                                            <button type='submit' class='btn btn-primary'>Submit Question</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
";
}else{
    $questionForm = "<p>Login to ask a question about the product</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
        background-color: #FFFCF2;
    }

    a {
        text-decoration: none;
    }

    .backgroundColorCard {
        background-color: #FFFCF2;
        border: none;
    }

    .oldPrice {
        text-decoration: line-through;
        color: #f64749;
    }

    .newPrice {
        color: #246eff;
    }

    .name {
        font-size: 3rem;
        text-transform: capitalize;
        font-weight: 700;
        position: relative;
        color: black;
        margin: 1rem 0;
    }

    .name::after {
        content: "";
        position: absolute;
        width: 80px;
        height: 4px;
        bottom: 0;
        left: 0;
        background: #EB5E28;
    }
    .buyBtn{
            width: 100%;
            max-width: 350px;
            float: left;
            background-color: #EB5E28;
            border:none;
            border-radius: 2px;
            height: 2rem;
            color: #FFFCF2;
        }
        .buyBtn:hover{
            background-color: rgba(235, 94, 40, 0.7);
            transition: 0.5s;
        }
        .review{
            border: 1px solid #CCC5B9;
            min-width: 301px;
        }
        
</style>
</head>

<body>
    <?php include_once "components/navbar.php" ?>
    <div class="container mb-5 mt-5">
        <div class="card mb-3 backgroundColorCard" style="width: 100%;">
            <div class="row no-gutters">
                <div class="col-md-5" style="height: 100%">
                    <img src="pictures/<?= $picture ?>" alt="<?= $name ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="col-md-5">
                    <div class="card-body">
                        <h1 class="card-title fw-bold text-uppercase name mt-0"><?= $name ?></h5>
                            <?php if ($discount > 0) : ?>
                                <p class="fw-semibold mb-0">Old Price: <span class="oldPrice fw-normal">€<?= $price ?></span></p>
                                <p class="fw-semibold">New Price: <span class="newPrice fw-normal ">€<?= number_format($priceWithDiscount, 2) ?> (-<?= $discount ?>%)</span></p>
                            <?php else : ?>
                                <p class="fw-semibold">Price: €<?= $price ?></p>
                            <?php endif; ?>
                            <h5 class="fw-semibold mb-0">About this Item:</h5>
                            <p>-<?= $details ?></p>
                            <p>Availability: <?= $availability ?></p>
                            <button onclick= 'addToCart(<?= $id ?>)' class='addToCartBtn buyBtn'>Add to Cart</button>
                    </div>
                </div>
            </div>
        </div><hr>
        <div class="container">
            <div class="row">
                <div class="col mb-5"><?= $reviewForm ?>
                    <div class="pt-2 pb-1" style="background-color: #403D39">
                        <h4 class="text-center text-light">Reviews</h4>
                    </div>
                    <div class="reviews-box" style="height:300px; overflow-y: scroll;">
                        <?php foreach ($reviews as $review) : ?>
                            <div class="review">
                                <div style='background-color: #CCC5B9'>
                                    <span class="fs-5 ps-1">Rating: <?= $review['rating'] ?> <i class="fa-solid fa-star" style="color: #EB5E28;"></i> </span>
                                </div>
                                <div>
                                    <span lass="fs-5 ps-1">Comment: <?= $review['comment'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            
                <div class="col">
                    <div class="pt-2 pb-1" style="background-color: #403D39"> <h4 class="text-center text-light">Previous Questions</h4>
                    </div>
                    <div class="review">
                        <?= $previousQuestions ?>
                        
                    </div>
                    <?= $questionForm ?>
                </div>
            </div>
        </div>
    </div>
    <script>
    function addToCart(productId) {
        console.log('Adding product to cart:', productId);

        fetch('shopping/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    // title: 'Oops...',
                    text: 'Product successfully added to the cart',
                    confirmButtonColor: '#EB5E28',
                })
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    confirmButtonColor: '#EB5E28',
                    })
                
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <?php include_once "components/footer.php"
    ?>
</body>

</html>
