<?php
include 'Connection.php';

$objet = new Connection();
$objet->createDatabase("CDT");

$objet->selectDatabase("CDT");
?>
