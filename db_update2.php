<?php
    require_once "connection.php";

    $q = "ALTER TABLE profiles
    ADD hobby VARCHAR(25)
    AFTER bio;";
    
    if($conn->query($q)){
        echo "<p> Uspesno izvrseno dodavanje kolone. </p>";
    }
    else {
        echo "Greska: " . $conn->error ;
    }


?>