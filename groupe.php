<?php
class Group {
    public $id;
    public $groupe;
    public $reg_date;

   
    public function __construct($groupe) {
        $this->groupe = $groupe;
    }

    
    public function insertGroup($tableName, $conn) {
        $sql = "INSERT INTO $tableName (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->groupe);

        if ($stmt->execute()) {
            echo "Group added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    
    public static function selectAllGroups($tableName, $conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            die("Error retrieving groups: " . $conn->error);
        }

        return $data;
    }

    public static function selectGroupById($tableName, $conn, $id) {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function updateGroup($group, $tableName, $conn, $id) {
        $sql = "UPDATE $tableName SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $group->groupe, $id);
        $stmt->execute();
    }

   
    public static function deleteGroup($tableName, $conn, $id) {
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            self::$successMsg = "groupe deleted successfully!";
        } else {
            self::$errorMsg = "Error deleting groupe: " . $conn->error;
        }
    }
}
?>
