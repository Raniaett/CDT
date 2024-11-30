<?php
class Module {
    public $id;
    public $name;
    public $reg_date;

    public static $errorMsg;
    public static $successMsg;

    public function __construct($name) {
        $this->name = $name;
    }

    
    public function insertModule($tableName, $conn) {
        $sql = "INSERT INTO $tableName (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->name);

        if ($stmt->execute()) {
            self::$successMsg = "Module added successfully!";
        } else {
            self::$errorMsg = "Error: " . $conn->error;
        }
    }

   
    public static function selectAllModules($tableName, $conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            self::$errorMsg = "Error retrieving modules: " . $conn->error;
        }

        return $data;
    }

    
    public static function selectModuleById($tableName, $conn, $id) {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

  
    public static function updateModule($module, $tableName, $conn, $id) {
        $sql = "UPDATE $tableName SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $module->name, $id);

        if ($stmt->execute()) {
            self::$successMsg = "Module updated successfully!";
        } else {
            self::$errorMsg = "Error updating module: " . $conn->error;
        }
    }

    
    public static function deleteModule($tableName, $conn, $id) {
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            self::$successMsg = "Module deleted successfully!";
        } else {
            self::$errorMsg = "Error deleting module: " . $conn->error;
        }
    }
}
?>
