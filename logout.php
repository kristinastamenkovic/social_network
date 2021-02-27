<?php
    session_start();
    if(isset($_SESSION['id'])){
        // brisemo sesiju
        $_SESSION = array();
        session_destroy();
    }

    header('Location: index.php');
?>