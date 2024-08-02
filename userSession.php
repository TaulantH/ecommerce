<?php

require_once "db_connect.php";

if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
    exit(); // Stop further execution
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit(); // Stop further execution
}
if (isset($_SESSION["user"])) {
    // Check if the logged-in user is banned
    $banCheckQuery = "SELECT COUNT(*) as isBanned FROM banlist WHERE fk_users = ? AND expiration_time > NOW()";
    $banCheckStmt = mysqli_prepare($connect, $banCheckQuery);
    
    if ($banCheckStmt) {
        mysqli_stmt_bind_param($banCheckStmt, "i", $_SESSION['user']);
        mysqli_stmt_execute($banCheckStmt);
        $banCheckResult = mysqli_stmt_get_result($banCheckStmt);
        $banCheckRow = mysqli_fetch_assoc($banCheckResult);
        // var_dump($banCheckRow['isBanned']);
        if ($banCheckRow['isBanned'] > 0) {
            // The user is banned, log them out and redirect
            session_destroy();
            $url = '//' . $_SERVER['HTTP_HOST'] . '/login.php';
            header("Location: $url");
            exit();
        }
        
        mysqli_stmt_close($banCheckStmt);
    }
}

