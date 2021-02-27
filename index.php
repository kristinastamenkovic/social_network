<?php
    session_start();
    require_once "connection.php";

    if(!empty($_SESSION['id'])){
        header('Location: followers.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to my site! <i class='fa fa-smile-o' style='color:orange'></i></h1>
    <div class='col-4 col-t-6' id='index'>
        <p>
            <a href='login.php' id='login'> Log in </a>
        </p>
        <p>
            Or
        </p>
        <p>
            <a href='register.php' id='account'> Create account </a>
        </p>
    </div>
</body>
</html>