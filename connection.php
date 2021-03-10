<?php

    // Kreiranje objekta konekcije

    $servername = 'localhost';
    $username = 'adminProjekat';
    $password = 'HWfasGWLiiD2K3lO';
    $db = 'mreza';

    $conn = new mysqli($servername, $username, $password, $db);
    if($conn->connect_error){
        die("Error connecting to database: " . $conn->connect_error);
    }
   
    
    

?>