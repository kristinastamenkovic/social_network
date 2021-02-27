<?php
    require_once "connection.php";

    $name = $surname = $gender = $dop = $username = $pass = $rePass = "";
    $nameErr = $surnameErr = $usernameErr = $passErr = $rePassErr = "";
    $valid = true;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST['name'])){
            $valid = false;
            $nameErr = "Error! You didn't enter your name";
        }
        elseif(strlen($_POST["name"]) > 50){
            $valid = false;
            $nameErr = "The name is too long";
        }
        else{
            $name = $conn->real_escape_string($_POST["name"]);
            if(!preg_match("/^[a-zA-Z ]*$/",$name)){ 
                $valid = false; 
                $nameErr = "Only alphabets and white space are allowed";  
            }
            $name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $name);
            $name = trim($name); 
        }

        if(empty($_POST['surname'])){
            $valid = false;
            $surnameErr = "Error! You didn't enter your surname";
        }
        elseif(strlen($_POST["surname"]) > 50){
            $valid = false;
            $surnameErr = "The surname is too long";
        }
        else {
            $surname = $conn->real_escape_string($_POST["surname"]);
            if(!preg_match("/^[a-zA-Z ]*$/",$surname)) { 
                $valid = false; 
                $surnameErr = "Only alphabets and white space are allowed";  
            } 
            $surname = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $surname);
            $surname = trim($surname); 
        }

        $gender = $conn->real_escape_string($_POST["gender"]);

        $dob = $conn->real_escape_string($_POST["dob"]);


        if(empty($_POST['username'])){
            $valid = false;
            $usernameErr = "Error! You didn't enter your username";
        }
        elseif(strlen($_POST["username"]) < 5){
            $valid = false;
            $usernameErr = "Username must contains between 5 and 50 characters";
        }
        elseif(strlen($_POST["username"]) > 50){
            $valid = false;
            $usernameErr = "Username must contains between 5 and 50 characters";
        }
        else {
            $username = $conn->real_escape_string($_POST["username"]);
            if(preg_match("/\s/",$username)){
                $valid = false;
                $usernameErr = "Username must not contain spaces";
            }
            $q ="SELECT username FROM users";
            $allUsernames = $conn->query($q);
            foreach($allUsernames as $row){
                if($row["username"] == $username){
                    $valid = false;
                    $usernameErr = "Username already exists";
                }
            }
        }

        if(empty($_POST['pass'])){
            $valid = false;
            $passErr = "Error! You didn't enter your password";
        }
        elseif(strlen($_POST["pass"]) < 5){
            $valid = false;
            $passErr = "Password must contains between 5 and 25 characters";
        }
        elseif(strlen($_POST["pass"]) > 25){
            $valid = false;
            $passErr = "Password must contains between 5 and 25 characters";
        }
        else {
            $pass = $conn->real_escape_string($_POST["pass"]);
            if(preg_match("/\s/",$pass)){
                $valid = false;
                $passErr = "Password must not contain spaces";
            }
            $pass = md5($pass);
        }

        if(empty($_POST['rePass'])){
            $valid = false;
            $rePassErr = "Error! You didn't retype password";
        }
        elseif($_POST['pass'] != $_POST['rePass']){
            $valid = false;
            $rePassErr = "Error! Your password is incorrect. Type again";
        }
        else {
            $rePass = $conn->real_escape_string($_POST["rePass"]);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
<h1> Create your account </h1>
    <form action="#" method="post">
        <p>
            <label for="">Name</label><br>
            <input type="text" name="name" id="" class='col-4 col-t-5' value="<?php echo $name ?>">
            <span class='error'>&nbsp * <?php echo $nameErr ?> </span>
        </p>

        <p>
            <label for="">Surname</label><br>
            <input type="text" name="surname" id="" class='col-4 col-t-5' value="<?php echo $surname ?>">
            <span class='error'>&nbsp * <?php echo $surnameErr ?> </span>
        </p>

        <p>
            <label for="">Gender: </label>
            <input type="radio" name="gender" id="" value="m">Male
            <input type="radio" name="gender" id="" value="f">Female
            <input type="radio" name="gender" id="" value="o" checked>Other
        </p>

        <p>
            <label for="">Date of birth </label>
            <input type="date" min="1900-01-01" max="2021-12-31" name="dob" id="">
        </p>

        <p>
            <label for="">Username</label><br>
            <input type="text" name="username" id="" class='col-4 col-t-5' value="<?php echo $username ?>">
            <span class='error'>&nbsp * <?php echo $usernameErr ?> </span>
        </p>

        <p>
            <label for="">Password</label><br>
            <input type="password" name="pass" id="" class='col-4 col-t-5'>
            <span class='error'>&nbsp *  <?php echo $passErr ?> </span>
        </p>

        <p>
            <label for="">Retype password</label><br>
            <input type="password" name="rePass" id="" class='col-4 col-t-5'>
            <span class='error'>&nbsp * <?php echo $rePassErr ?> </span>
        </p>

        <p>
            <input type="submit" name="submit" value="Sign up" class='col-2 col-t-3'>
        </p>

        <p class='row'>
            <span class='error'>* Required fields. </span>
        </p>

    </form>
</body>
</html>
   
    

    <?php
        if($valid && $name!='' && $surname!='' && $gender!='' && $dob!=''){

            $q1 = "INSERT INTO users(username, pass)
            VALUES
            ('$username', '$pass')";
            if($conn->query($q1)){
                
                $q = "SELECT `id`   
                FROM `users`";
                $user_id = $conn->insert_id;
              
                $q2 = "INSERT INTO profiles(`name`, `surname`, `gender`, `dob`, `user_id`)
                VALUES
                ('$name','$surname','$gender','$dob','$user_id')";
                if($conn->query($q2)){
                echo "<p class='success'><i class='fa fa-check'></i> You have successfully signed up. </p>";
                }
                else {
                    echo "<p class='error'> Error! " . $conn->error . "</p>";
                }
            }
            else {
                echo "<p class='error'> Error! " . $conn->error . "</p>";
            }
           
        }
    

    ?>

