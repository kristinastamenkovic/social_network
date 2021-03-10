<?php
    require_once "connection.php";
    require_once "validation.php";

    $name = $surname = $gender = $dob = $username = $pass = $rePass = "";
    $nameErr = $surnameErr = $dobErr = $usernameErr = $passErr = $rePassErr = "";
    $valid = true;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(textValidation($_POST['name'])){
            $valid = false;
            $nameErr = textValidation($_POST['name']);
        }
        else {
            $name = $conn->real_escape_string($_POST["name"]);
            $name = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $name);
            $name = trim($name); 
        }

        if(textValidation($_POST['surname'])){
            $valid = false;
            $surnameErr = textValidation($_POST['surname']);
        }
        else {
            $surname = $conn->real_escape_string($_POST["surname"]);
            $surname = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $surname);
            $surname = trim($surname); 
        }

        $gender = $conn->real_escape_string($_POST["gender"]);

        if(dobValidation($_POST['dob'])){
            $valid = false;
            $dobErr = dobValidation($_POST['dob']);
        }
        else {
            $dob = $conn->real_escape_string($_POST["dob"]);
        }

        if(usernameValidation($_POST['username'], $conn)){
            $valid = false;
            $usernameErr = usernameValidation($_POST['username'], $conn);
        }
        else {
            $username = $conn->real_escape_string($_POST["username"]);
        }

        if(passwordValidation($_POST['pass'])){
            $valid = false;
            $passErr = passwordValidation($_POST['pass']);
        }
        else {
            $pass = $conn->real_escape_string($_POST["pass"]);
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


        if($valid && $name!='' && $surname!=''){

            $q1 = "INSERT INTO users(`username`, `pass`)
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
    <a href='index.php' id='back' class='col-1 col-t-1'> Back </a>
    <h1> Create your account </h1>
    <form action="#" method="post">
        <p>
            <label for="">Name</label><br>
            <input type="text" name="name" id="" class='col-4 col-t-5' value="<?php echo $name ?>">
            <span class='error'>* <?php echo $nameErr ?> </span>
        </p>

        <p>
            <label for="">Surname</label><br>
            <input type="text" name="surname" id="" class='col-4 col-t-5' value="<?php echo $surname ?>">
            <span class='error'>* <?php echo $surnameErr ?> </span>
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
            <span class='error'>* <?php echo $dobErr ?> </span>
        </p>

        <p>
            <label for="">Username</label><br>
            <input type="text" name="username" id="" class='col-4 col-t-5' value="<?php echo $username ?>">
            <span class='error'> * <?php echo $usernameErr ?> </span>
        </p>

        <p>
            <label for="">Password</label><br>
            <input type="password" name="pass" id="" class='col-4 col-t-5'>
            <span class='error'> *  <?php echo $passErr ?> </span>
        </p>

        <p>
            <label for="">Retype password</label><br>
            <input type="password" name="rePass" id="" class='col-4 col-t-5'>
            <span class='error'> * <?php echo $rePassErr ?> </span>
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
   
    
