<?php
    session_start();
    require_once "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Social Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="row">
        <nav>
            <ul>
                <li class="col-2 col-t-2"><a href="index.php"> Home  </a></li>
                <li class="col-2 col-t-2"><a href="followers.php"> Friends </a></li>
                <li class="col-3 col-t-3"><a href="changeProfile.php"> Change profile </a></li>
                <li class="col-3 col-t-3"><a href="changePass.php"> Change password </a></li>
                <li class="col-2 col-t-2"><a href="logout.php"> Logout </a></li>
            </ul>
        </nav>
    </div>
