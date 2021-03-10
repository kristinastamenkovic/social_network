<?php
    // otvaranje sesije na pocetku stranice
    session_start();

    require_once "connection.php";

    $usernameErr = $passErr = "*";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $conn->real_escape_string($_POST['username']);
        $pass = $conn->real_escape_string($_POST['pass']);
        $val = true;

        if(empty($username)){
            $val = false;
            $usernameErr = "Username cannot be left blank";
        }
        if(empty($pass)){
            $val = false;
            $passErr = "Password cannot be left blank";
        }
        if($val){
            // pokusamo da ulogujemo korisnika samo ako su sva polja forme neprazna
            $q = "SELECT users.username, users.id AS 'id', users.pass AS 'pass', 
            profiles.name AS 'name', profiles.surname AS 'surname', 
            profiles.gender AS 'gender', profiles.dob AS 'dob'
            FROM users
            INNER JOIN profiles
            ON profiles.user_id = users.id
            WHERE username = '$username'";
            $result = $conn->query($q);
            if($result->num_rows == 0){
                $usernameErr = "This username doesn't exist";
            }
            else {
                //postoji username, treba proveriti sifre
                $row = $result->fetch_assoc();
                $dbPass = $row['pass']; // password koji postoji u bazi
                if($dbPass != md5($pass)){
                    $passErr = "Incorect password";
                }
                else {
                    // ovde vrsimo logovanje
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    $_SESSION['gender'] = $row['gender'];
                    header('Location: followers.php');
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to the site</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id='welcome'>
    <div>
        <form action="#" method="POST" id='loginForm'>
            <p>
                <label for="username">Username</label><br>
                <input type="text" name="username" id="username">
                <span class='error'> <?php echo $usernameErr ?></span>
            </p>

            <p>
                <label for="pass">Password</label><br>
                <input type="password" name="pass" id="pass">
                <span class='error'> <?php echo $passErr ?> </span>
            </p>

            <p>
                <input type="submit" name='submit' value="Log in" id='submit'>
            </p>
            
        </form>
    </div>
    
</body>
</html>