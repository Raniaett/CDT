<?php
include 'Connection.php';
include 'Client.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $objet = new Connection();
    $objet->selectDatabase("chap4Db");

    Client::deleteClient("Clients", $objet->conn, $id);

    header("Location: read.php");
    exit;
}
?>
