<?php
class Client {
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $reg_date;
    public $idCategory;
    public $idGroupe;
    public $idModule;
    public $idFilier;

    public static $errorMsg;
    public static $successMsg;

    // Updated constructor to include the new parameters
    public function __construct($firstname, $lastname, $email, $password, $idCategory = null, $idGroupe = null, $idModule = null, $idFilier = null) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->idCategory = $idCategory;
        $this->idGroupe = $idGroupe;
        $this->idModule = $idModule;
        $this->idFilier = $idFilier;
    }

    // Insert client with the new parameters
    public function insertClient($tableName, $conn) {
        $sql = "INSERT INTO $tableName (firstname, lastname, email, password, idCategory, idGroupe, idModule, idFilier) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiii", $this->firstname, $this->lastname, $this->email, $this->password, $this->idCategory, $this->idGroupe, $this->idModule, $this->idFilier);

        if ($stmt->execute()) {
            self::$successMsg = "Client added successfully!";
        } else {
            self::$errorMsg = "Error: " . $conn->error;
        }
    }

    // Select all clients
    public static function selectAllClients($tableName, $conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            self::$errorMsg = "Error retrieving clients: " . $conn->error;
        }

        return $data;
    }

    // Select client by ID
    public static function selectClientById($tableName, $conn, $id) {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update client information, including the new fields
    public static function updateClient($client, $tableName, $conn, $id) {
        $sql = "UPDATE $tableName SET firstname = ?, lastname = ?, email = ?, password = ?, idCategory = ?, idGroupe = ?, idModule = ?, idFilier = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiiii", $client->firstname, $client->lastname, $client->email, $client->password, $client->idCategory, $client->idGroupe, $client->idModule, $client->idFilier, $id);

        if ($stmt->execute()) {
            self::$successMsg = "Client updated successfully!";
        } else {
            self::$errorMsg = "Error updating client: " . $conn->error;
        }
    }

    // Delete a client by ID
    public static function deleteClient($tableName, $conn, $id) {
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            self::$successMsg = "Client deleted successfully!";
        } else {
            self::$errorMsg = "Error deleting client: " . $conn->error;
        }
    }
}
?>
