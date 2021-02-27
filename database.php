<?php
    require_once "connection.php";

    $q = "CREATE TABLE IF NOT EXISTS users(
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        pass VARCHAR(255) NOT NULL
    )
    ENGINE = InnoDB;";
    $q .= "CREATE TABLE IF NOT EXISTS profiles(
        `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL,
        `surname` VARCHAR(50) NOT NULL,
        `gender` CHAR(1),
        `dob` DATE,
        `user_id` INT UNSIGNED,
        FOREIGN KEY(`user_id`) REFERENCES users(id)
    )
    ENGINE = InnoDB;";
    $q .= "CREATE TABLE IF NOT EXISTS followers(
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        sender_id INT UNSIGNED NOT NULL,
        receiver_id INT UNSIGNED NOT NULL,
        FOREIGN KEY(sender_id) REFERENCES users(id),
        FOREIGN KEY(receiver_id) REFERENCES users(id)
    )
    ENGINE = InnoDB;";

    if($conn->multi_query($q)){
        echo "<p> Uspesno izvrseno kreiranje tabela. </p>";
    }
    else {
        echo "Greska prilikom kreiranja tabela: " . $conn->error ;
    }






?>