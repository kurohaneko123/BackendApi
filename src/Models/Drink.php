<?php
namespace App\Models;

use Database;

class Drink {
    private $conn;
    
    public function __construct() {
        $db = new \Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $query = "SELECT * FROM drinks";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // ... (bên trong class Drink ở Drink.php)
public function getById($id) {
    $query = "SELECT * FROM drinks WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

}
?>
