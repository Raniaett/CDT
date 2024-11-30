<?php
class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createDatabase($dbName) {
        $dbName = $this->conn->real_escape_string($dbName);
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if ($this->conn->query($sql) === TRUE) {
            echo "Database '$dbName' created successfully<br>";
        } else {
            echo "Error creating database: " . $this->conn->error . "<br>";
        }
    }
    
    public function selectDatabase($dbName) {
        mysqli_select_db($this->conn, $dbName);
    }

    public function createTable($query) {
        if ($this->conn->query($query) === TRUE) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . $this->conn->error . "<br>";
        }
    }
}
?>
