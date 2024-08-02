<?php
    require_once "../db_connect.php";
    //   check session
    session_start();

    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }
    if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
        header("Location: ../login.php");
    }

    $productID = $_GET['id'];
    $searchProduct = "SELECT products.ID, name, price, details, fk_category, picture, availability, display, c.category as category FROM products JOIN categories AS c ON products.fk_category = c.ID WHERE products.ID = $productID";
    $result = $connect->query($searchProduct);
    $row = $result->fetch_assoc();

    // variables
    $name = $row['name'];
    $price = $row['price'];
    $details = $row['details'];
    $category = $row['fk_category'];
    $categoryName = $row['category'];
    $picture = $row['picture'];
    $availability = $row['availability'];
    $display = $row['display'];
    
    $getReviews = "SELECT reviews.id AS ID, u.username, u.id AS userID, rating, comment, created_at AS created FROM reviews JOIN users AS u ON reviews.user_id = u.id WHERE product_id = $productID ";
    $reviewResult = $connect->query($getReviews);

    $reviews = "";
    if(mysqli_num_rows($reviewResult) > 0){
        while($rowReviews = $reviewResult->fetch_assoc()){
            $reviews .="<div>
                            <a href='../users/banUser.php?id={$rowReviews['userID']}'><p>{$rowReviews['username']}<p></a>
                            <p>{$rowReviews['created']}</p>
                            <p>{$rowReviews['rating']}</p>
                            <p>{$rowReviews['comment']}</p>
                            <form action='deleteReview.php?reviewID={$rowReviews['ID']}' method='POST'>
                                <input type='hidden' name='productID' value={$productID}>
                                <button type='submit' class='btn btn-danger'>Delete</button>
                            </form>
                            
                            
                        </div>";
        }
    }
// update answers if form is submitted
    if(isset($_POST['sendAnswer'])){
        $answer = $_POST['answer'];
        $questionID = $_POST['questionID'];

        $updateAnswer = "UPDATE `questions` SET `answer`= ? WHERE id = $questionID";

        $stmt = mysqli_prepare($connect, $updateAnswer);

        if (!$stmt) {
            die("Preparation failed: " . mysqli_error($connect));
        }

        mysqli_stmt_bind_param($stmt, "s", $answer);
        mysqli_stmt_execute($stmt);
    }

    // get all questions and display
    $getQuestions = "SELECT questions.id AS ID, u.username, u.id AS userID, question_text AS question, created_at AS created, answer FROM `questions` JOIN users AS u ON questions.user_id = u.id WHERE product_id = $productID";
    $questionsResult = $connect->query($getQuestions);

    $questions = "";
    
    if(mysqli_num_rows($questionsResult) > 0){
        while($rowQuestions = $questionsResult->fetch_assoc()){
            $answer = ($rowQuestions['answer'] != null) ? "<p>answer: {$rowQuestions['answer']}" : "";
            $questions .="<div>
                            <a href='../users/banUser.php?id={$rowQuestions['userID']}'><p>{$rowQuestions['username']}<p></a>
                            <p>{$rowQuestions['created']}</p>
                            <p>{$rowQuestions['question']}</p>
                            $answer
                            <form action='deleteQuestion.php?questionID={$rowQuestions['ID']}' method='POST'>
                                <input type='hidden' name='productID' value={$productID}>
                                <button type='submit' class='btn btn-danger'>Delete</button>
                            </form>
                            <form method='POST'>
                                <input type='hidden' name='questionID' value={$rowQuestions['ID']}>
                                <textarea name=answer cols=30 rows=3 placeholder='Write a new answer here...'></textarea>
                                <button type='submit' class='btn btn-primary' name='sendAnswer'>Answer</button>
                            </form>
                            
                        </div>";
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
</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
    <h1>Details</h1>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">price</th>
            <th scope="col">details</th>
            <th scope="col">category</th>
            <th scope="col">picture</th>
            <th scope="col">availabilty</th>
            <th scope="col">display</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row"><?= $productID ?></th>
            <td><?= $name ?></td>
            <td><?= $price ?></td>
            <td><?= $details ?></td>
            <td><?= $categoryName ?></td>
            <td><?= $picture ?></td>
            <td><?= $availability ?></td>
            <td><?= $display ?></td>

            </tr>
        </tbody>
    </table>
    <h3>Reviews</h3>
    <?= $reviews ?>
    <h3>Questions</h3>
    <?= $questions ?>

</body>
</html>