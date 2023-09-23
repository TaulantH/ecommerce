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
$question_text = $_POST['question_text'];


// Get the user ID from the session
$userID = $_SESSION["user"];

// Perform database insertion
$sqlInsertReview = "INSERT INTO questions (user_id, question_text, product_id) VALUES (?, ?, ?)";
$stmtInsertReview = mysqli_prepare($connect, $sqlInsertReview);

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmtInsertReview, "isi", $userID, $question_text, $productID);

$response = array('success' => false, 'message' => '');

// Check if the insertion was successful
if (mysqli_stmt_execute($stmtInsertReview)) {
    $response['success'] = true;
    $response['message'] = 'Question submitted successfully';
    // Redirect back to the index page after successful question submission
    header("Location: details.php?id=$productID");
    exit();
} else {
    $response['message'] = 'Error submitting question';
}

// Redirect back to the product page with the updated question in case of an error
header("Location: details.php?id=$productID");
exit();
?>
