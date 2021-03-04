<?php
    require_once "connection.php";
    require_once "header.php";

    if(empty($_GET['id'])){
        echo "<p> There's no user in database. </p>";
    }
    else {
        $idKorisnika = $conn->real_escape_string($_GET['id']);
        $fullName = "{$_SESSION['name']} {$_SESSION['surname']}";
        echo "<h2 id='hello'> Hello, {$fullName}! </h2>";
    }
    

    $q = "SELECT profiles.name AS 'name', profiles.surname AS 'surname',
    profiles.gender AS 'gender', profiles.dob AS 'dob', profiles.bio AS 'bio',
    users.username AS 'username', users.id AS 'id'
    FROM profiles
    INNER JOIN users
    ON profiles.user_id = users.id
    WHERE users.id = $idKorisnika";

    $result = $conn->query($q);
    if(!$result->num_rows){
        echo "There's no data in the database.";
    }
    else {
        foreach($result as $row){
            if($row['gender'] == "m"){
                echo "<table class='profileTable' id='m'>";
            }
            elseif($row['gender'] == 'f'){
                echo "<table class='profileTable' id='f'>";
            }
            else {
                echo "<table class='profileTable' id='o'>";
            }
            echo "<tr>
                <td> First name </td>
                <td>" . $row['name'] . "</td> ";
            echo "</tr>";
            echo "<tr>
                <td> Last name </td>
                <td>" . $row['surname'] . "</td> ";
            echo "</tr>";
            echo "<tr>
                <td> Username </td>
                <td>" . $row['username'] . "</td> ";
            echo "</tr>";
            echo "<tr>
                <td> Date of birth </td>
                <td>" . $row['dob'] . "</td> ";
            echo "</tr>";
            echo "<tr>
                <td> Gender </td>
                <td>" . $row['gender'] . "</td> ";
            echo "</tr>";
            echo "<tr>
                <td> About me </td>
                <td>" . $row['bio'] . "</td> ";
            echo "</tr>";
            echo "</table>";
        }
    }
    echo "<a href='followers.php' id='back' class='col-1 col-t-1'> Back </a>";



?>