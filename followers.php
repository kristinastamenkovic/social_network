<?php
    require_once "connection.php";
    require_once "header.php";

    if(empty($_SESSION['id'])){
        header('Location: index.php');
    }
    $idKorisnika = $_SESSION['id'];
    $fullName = "{$_SESSION['name']} {$_SESSION['surname']}";

    echo "<h2> Hello,  <a href='profile.php?id=$idKorisnika'>{$fullName}</a>! </h2>";
    /*
    if($_SESSION['gender'] == 'm'){

        echo "<h2 id='hello' style='color:blue'> Hello, {$fullName}! </h2>";
    }
    elseif($_SESSION['gender'] == 'f'){
        echo "<h2 id='hello' style='color:red'> Hello, {$fullName}! </h2>";
    }
    else {
        echo "<h2 id='hello' style='color:green'> Hello, {$fullName}! </h2>";
    }*/
    
    if(!empty($_GET['follow'])){
        $friendId = $conn->real_escape_string($_GET['follow']);

        $q = "SELECT * FROM followers
                WHERE sender_id = $idKorisnika
                AND receiver_id = $friendId";

        $result = $conn->query($q);
        if($result->num_rows == 0){
            $q = "INSERT INTO followers(sender_id, receiver_id)
            VALUE ($idKorisnika, $friendId)";
            $result1 = $conn->query($q);
            if(!$result1){
                echo "<div class='error'>Error: " . $conn->error . "</div>";
            }
        }
    }

    if(!empty($_GET['unfollow'])){
        $friendId = $conn->real_escape_string($_GET['unfollow']);

        $q = "DELETE FROM followers
        WHERE sender_id = $idKorisnika
        AND receiver_id = $friendId"; 

        $result = $conn->query($q); 
        if(!$result){
            echo "<div class='error'> Error: " . $conn->error . "</div>";
        }
    }
    

    $q = "SELECT profiles.name AS 'name', profiles.surname AS 'surname', profiles.user_id, 
    users.id AS 'id', users.username AS 'username'
    FROM users
    INNER JOIN profiles
    ON profiles.user_id = users.id
    WHERE users.id != $idKorisnika
    ORDER BY profiles.name ";

    $result = $conn->query($q);
    if($result->num_rows == 0){
        echo "<p class='info'> There's no data in the database. </p>";
    }
    else {
        echo "<table class = 'table'>";
        echo "<tr>
        <th> Full name </th>
        <th> Username </th>
        <th> Action </th>
        </tr>";
        foreach($result as $row){
            echo "<tr>";
            $friendId = $row['id'];
            echo "<td> <a href='profile.php?id=$friendId'>" . $row['name'] . " " . $row['surname'] . "</a></td>";
            echo "<td>" . $row['username'] . "</td>";
            $q1 = "SELECT * FROM followers
            WHERE sender_id = $idKorisnika
            AND receiver_id = $friendId;";
            $q2 ="SELECT * FROM followers
            WHERE receiver_id = $idKorisnika
            AND sender_id = $friendId";
            if($conn->query($q1)->num_rows == 0 && $conn->query($q2)->num_rows == 0){
                echo "<td> <a href='followers.php?follow=$friendId' id='follow'><i class='material-icons'style='font-size:16px'>person_add</i> Follow </td>";
            }
            elseif($conn->query($q1)->num_rows == 0 && $conn->query($q2)->num_rows == 1){
                echo "<td> <a href='followers.php?follow=$friendId' id='follow'><i class='material-icons'style='font-size:16px'>person_add</i> Follow back </td>";
            }
            elseif($conn->query($q1)->num_rows == 1){
                echo "<td> <a href='followers.php?unfollow=$friendId' id='unfollow'> Unfollow </a> </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }


?>

</body>
</html>