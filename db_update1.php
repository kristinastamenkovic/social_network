<?php
    require_once "connection.php";

    $q = "ALTER TABLE profiles
    ADD bio TEXT
    AFTER dob;";
    
    if($conn->query($q)){
        echo "<p> Uspesno izvrseno dodavanje kolone. </p>";
    }
    else {
        echo "Greska: " . $conn->error ;
    }


?>