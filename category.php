<?php
class Category {
    public $id;
    public $name;
    public $reg_date;

    public static $errorMsg;
    public static $successMsg;

    public function __construct($name) {
        $this->name = $name;
    }

    
    public function insertCategory($conn) {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->name);

        if ($stmt->execute()) {
            echo "Category added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    
    public static function selectAllCategories($tableName,$conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            die("Error retrieving categories: " . $conn->error);
        }

        return $data;
    }

    
    public static function selectCategoryById($conn, $id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    
    public static function updateCategory($conn, $id, $name) {
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            echo "Category updated successfully!";
        } else {
            echo "Error updating category: " . $conn->error;
        }
    }

  
    public static function deleteCategory($conn, $id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            self::$successMsg = "category deleted successfully!";
        } else {
            self::$errorMsg = "Error deleting category: " . $conn->error;
        }
    }
}
?>
