<?php

    $localhost = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_fullstack_ecommerce";

    // create connection
    $connect = mysqli_connect($localhost, $username, $password, $dbname);

    // check connection
    if (!$connect) {
    die ("Connection failed");
    }
