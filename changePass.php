<?php
    require_once "connection.php";
    require_once "header.php";

    
    if(empty($_SESSION['id'])){
        header('Location: index.php');
    }
    $idKorisnika = $_SESSION['id'];
    $fullName = "{$_SESSION['name']} {$_SESSION['surname']}";

    echo "<h2 id='hello'> Hello, {$fullName}! </h2>";

    $q = "SELECT * FROM users
    WHERE `id` = $idKorisnika";

    $result = $conn->query($q);
    $row = $result->fetch_assoc();

    $oldPass = $row['pass'];
    $newPass = $reNewPass = " ";
    $oldPassErr = $passErr = $rePassErr = " ";
    $valid = true;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        if(empty($_POST['oldPass'])){
            $valid = false;
            $oldPassErr = "Error! You didn't enter your password";
        }
        elseif($oldPass != md5($conn->real_escape_string($_POST['oldPass']))){
            $valid = false;
            $oldPassErr = "Error! Password is incorect";
        }

        if(empty($_POST['newPass'])){
            $valid = false;
            $passErr = "Error! You didn't enter your password";
        }
        elseif(strlen($_POST["newPass"]) < 5){
            $valid = false;
            $passErr = "Password must contains between 5 and 25 characters";
        }
        elseif(strlen($_POST["newPass"]) > 25){
            $valid = false;
            $passErr = "Password must contains between 5 and 25 characters";
        }
        else {
            $pass = $conn->real_escape_string($_POST["newPass"]);
            if(preg_match("/\s/",$pass)){
                $valid = false;
                $passErr = "Password must not contain spaces";
            }
            $pass = md5($pass);
        }

        if(empty($_POST['reNewPass'])){
            $valid = false;
            $rePassErr = "Error! You didn't retype password";
        }
        elseif($_POST['newPass'] != $_POST['reNewPass']){
            $valid = false;
            $rePassErr = "Error! Your password is incorrect. Type again";
        }
        else {
            $rePass = $conn->real_escape_string($_POST["reNewPass"]);
        }

        
        if($valid){
            $q = "UPDATE users
            SET `pass`='$pass'
            WHERE `id` = $idKorisnika
            ";

            if($conn->query($q)){
            echo "<p class='success'><i class='fa fa-check'></i> You have successfully changed your password. </p>";
            }
            else {
                echo "<p class='error'> Error! " . $conn->error . "</p>";
            }
        }
    }
?>
    <h1> Change your password </h1>
    <form action="#" method="post">
        <p>
            <label for="">Old password</label><br>
            <input type="password" name="oldPass" id="" class='col-4 col-t-5'>
            <span class='error'>*  <?php echo $oldPassErr ?> </span>
        </p>
       
        <p>
            <label for="">New password</label><br>
            <input type="password" name="newPass" id="" class='col-4 col-t-5'>
            <span class='error'>*  <?php echo $passErr ?> </span>
        </p>

        <p>
            <label for="">Retype new password</label><br>
            <input type="password" name="reNewPass" id="" class='col-4 col-t-5'>
            <span class='error'>* <?php echo $rePassErr ?> </span>
        </p>

        <p>
            <input type="submit" name="submit" value="Confirm" class='col-2 col-t-3'>
        </p>

        <p id="mark" class='row'>
            <span class='error'>* Required fields. </span>
        </p>

    </form>
    

</body>
</html>