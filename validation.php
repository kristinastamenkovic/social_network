<?php
    require_once "connection.php";

    function textValidation($text){
        if(empty($text)){
            return "Enter value";
        }
        elseif(!preg_match("/^[a-zA-Z ]*$/",$text)){
            return "Only alphabets and white space are allowed";  
        }
        elseif(strlen($text) > 50){
            return "The name is too long";
        }
        else {
            return false;
        }
    }

    function dobValidation($dob){
        if(empty($dob)){
            return false;
        }
        elseif($dob < "1900-01-01"){
            return "Dates are available after 1900 01 01";
        }
        else {
            return false;
        }
    }

    function usernameValidation($username, $conn){
        $q = "SELECT `username` FROM users WHERE `username` LIKE '$username'";
        $result = $conn->query($q);
        if(empty($username)){
            return "Enter value";
        }
        elseif(preg_match("/\s/",$username)){
            return "Username must not contain spaces";
        }
        elseif($result->num_rows){
            return "The username you entered already exists";
        }
        elseif(strlen($username) < 5){
            return "Username must contains between 5 and 50 characters";
        }
        elseif(strlen($username) > 50){
            return "Username must contains between 5 and 50 characters";
        }
        else {
            return false;
        }
    }

    function passwordValidation($pass){
        if(empty($pass)){
            return "Enter value";
        }
        elseif(preg_match("/\s/",$pass)){
            return "Password must not contain spaces";
        }
        elseif(strlen($pass) < 5){
            return "Password must contains between 5 and 25 characters";
        }
        elseif(strlen($pass) > 25){
            return "Password must contains between 5 and 25 characters";
        }
        else {
            return false;
        }
    }

    function bioValidation($bio){
        if(empty($bio)){
            return "You didn't enter your bio";
        }
        else {
            return false;
        }
    }



?>