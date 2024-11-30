<?php
class Filiere {
    public $id;
    public $name;

    public static $errorMsg;
    public static $successMsg;

    public function __construct($name) {
        $this->name = $name;
    }

    
    public function insertFiliere($tableName, $conn) {
        $sql = "INSERT INTO $tableName (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->name);

        if ($stmt->execute()) {
            self::$successMsg = "Filiere added successfully!";
        } else {
            self::$errorMsg = "Error: " . $conn->error;
        }
    }

    
    public static function selectAllFilieres($tableName, $conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            self::$errorMsg = "Error retrieving filieres: " . $conn->error;
        }

        return $data;
    }

   
    public static function selectFiliereById($tableName, $conn, $id) {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            self::$errorMsg = "Error retrieving filiere: " . $conn->error;
            return null;
        }
    }

    
    public static function updateFiliere($filiere, $tableName, $conn, $id) {
        $sql = "UPDATE $tableName SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $filiere->name, $id);

        if ($stmt->execute()) {
            self::$successMsg = "Filiere updated successfully!";
        } else {
            self::$errorMsg = "Error updating filiere: " . $conn->error;
        }
    }

   
    public static function deleteFiliere($tableName, $conn, $id) {
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            self::$successMsg = "Filiere deleted successfully!";
        } else {
            self::$errorMsg = "Error deleting filiere: " . $conn->error;
        }
    }
}
?>
