<?php
include 'database.php';
$query = "
CREATE TABLE IF NOT EXISTS Groupes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$objet->createTable($query);
?>