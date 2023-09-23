<?php
session_start();
require_once "db_connect.php";

// Check if the user is not logged in
if (!isset($_SESSION["user"])) {
    // Redirect user if not logged in
    header("Location: login.php");
    exit();
}

// Get the product ID from the GET request
$productID = isset($_GET['product_id']) ? $_GET['product_id'] : null;

// Get rating and comment from the POST request
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Get the user ID from the session
$userID = $_SESSION['user'];
$sqlCheckPurchase = "SELECT * FROM purchases WHERE user_id = ? AND product_id = ?";
$stmtCheckPurchase = mysqli_prepare($connect, $sqlCheckPurchase);

if (!$stmtCheckPurchase) {
    die("Preparation failed: " . mysqli_error($connect));
}

mysqli_stmt_bind_param($stmtCheckPurchase, "ii", $userID, $id);
mysqli_stmt_execute($stmtCheckPurchase);
$resultCheckPurchase = mysqli_stmt_get_result($stmtCheckPurchase);
$canSubmitReview = mysqli_num_rows($resultCheckPurchase) > 0;

// Perform database insertion
$sqlInsertReview = "INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)";
$stmtInsertReview = mysqli_prepare($connect, $sqlInsertReview);

// Validate and sanitize user inputs
$rating = intval($rating); // Make sure the rating is an integer
$comment = mysqli_real_escape_string($connect, $comment);

$response = array('success' => false, 'message' => '');

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmtInsertReview, "iiis", $userID, $productID, $rating, $comment);

// Check if the insertion was successful
if (mysqli_stmt_execute($stmtInsertReview)) {
    $response['success'] = true;
    $response['message'] = 'Review submitted successfully';
} else {
    $response['message'] = 'Error submitting review';
}

// Close the prepared statement
mysqli_stmt_close($stmtInsertReview);

// Store the response message in a session variable
$_SESSION['review_response'] = $response;
// After successful review submission
$_SESSION['review_submitted'] = true;


// Redirect back to the product page
header("Location: details.php?id=$productID");
exit();
?>
