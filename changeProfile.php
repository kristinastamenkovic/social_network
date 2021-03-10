<?php
    require_once "connection.php";
    require_once "header.php";
    require_once "validation.php";

    if(empty($_SESSION['id'])){
        header('Location: index.php');
    }
    $idKorisnika = $_SESSION['id'];
    $fullName = "{$_SESSION['name']} {$_SESSION['surname']}";

    echo "<h2 id='hello'> Hello, {$fullName}! </h2>";

    $q = "SELECT profiles.name AS 'name', profiles.surname AS 'surname',
    profiles.gender AS 'gender', profiles.dob AS 'dob', profiles.bio AS 'bio',
    profiles.hobby AS 'hobby', users.id AS 'id'
    FROM profiles
    INNER JOIN users
    ON profiles.user_id = users.id
    WHERE users.id = $idKorisnika";

    $result = $conn->query($q);
    $row = $result->fetch_assoc();
    
    
    // postavljanje pocetnih vrednosti
    $name = $surname = $gender = $dob = $bio = "";
    $hobbies = array();
    $nameErr = $surnameErr = $dobErr = $bioErr = "";
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


        if(bioValidation($_POST['bio'])){
            $valid = false;
            $bioErr = bioValidation($_POST['bio']);
        }
        else {
            $bio = $conn->real_escape_string($_POST["bio"]);
        }


        $hobbies[] = $conn->real_escape_string($_POST["hobbies"]);
        $hobbies = implode(', ' , $hobbies) ;

        if($valid){
            $q = "UPDATE profiles
            SET `name`='$name',`surname`='$surname',`gender`='$gender',`dob`='$dob', `bio`='$bio', `hobby`='$hobbies'
            WHERE `user_id` = $idKorisnika";

            if($conn->query($q)){
            echo "<p class='success'><i class='fa fa-check'></i> You have successfully changed your profile. </p>";
            }
            else {
                echo "<p class='error'> Error! " . $conn->error . "</p>";
            }
        }

    }
?>
    <h1> Change your profile </h1>
    <form action="#" method="post">
        <p>
            <label for="">Name</label><br>
            <input type="text" name="name" id="" class='col-4 col-t-5' value="<?php echo $row['name'] ?>">
            <span class='error'>* <?php echo $nameErr ?> </span>
        </p>

        <p>
            <label for="">Surname</label><br>
            <input type="text" name="surname" id="" class='col-4 col-t-5' value="<?php echo $row['surname'] ?>">
            <span class='error'> * <?php echo $surnameErr ?> </span>
        </p>

        <p>
            <label for="">Gender: </label>
            <input type="radio" name="gender" id="" value="m" <?php if($row['gender'] == 'm'){echo 'checked';} ?> >Male
            <input type="radio" name="gender" id="" value="f" <?php if($row['gender'] == 'f'){echo 'checked';} ?>>Female
            <input type="radio" name="gender" id="" value="o" <?php if($row['gender'] != 'm' && $gender != 'f'){echo 'checked';} ?>>Other
        </p>

        <p>
            <label for="">Date of birth </label>
            <input type="date" min="1900-01-01" max="2021-12-31" name="dob" id="" value='<?php echo $row['dob'] ?>'>
            <span class='error'> * <?php echo $dobErr ?> </span>
        </p>

        <p>
            <label for="">Bio: </label>
            <textarea name="bio" id="" cols="30" rows="3" placeholder="<?php echo $row['bio'] ?>"></textarea>
            <span class='error'> * <?php echo $bioErr ?> </span>
        </p>

        <p>
            <label>Hobbies:</label>
            <input type="checkbox" name="hobbies" value="sport" <?php if($row['hobby'] == 'sport'){echo 'checked';} ?> > Sport
            <input type="checkbox" name="hobbies" value="cooking" <?php if($row['hobby'] == 'cooking'){echo 'checked';} ?> > Cooking
            <input type="checkbox" name="hobbies" value="books" <?php if($row['hobby'] == 'books'){echo 'checked';} ?> > Books
        </p>

        <p>
            <input type="submit" name="submit" value="Confirm" class='col-2 col-t-3'>

        </p>

        <p id="mark" class='row'>
            <span class='error'> * Required fields. </span>
        </p>

    </form>
    

</body>
</html>