<?php
include 'database.php';
$query = "
CREATE TABLE IF NOT EXISTS Clients (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(80),
    idCategory VARCHAR(30) NOT NULL,
    idModule VARCHAR(30) NOT NULL,
    idFilier VARCHAR(30) NOT NULL,
    idGroupe VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$objet->createTable($query);
?>