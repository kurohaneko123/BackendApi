<?php
namespace App\Models;

use App\Config\Database;

class Drink {
    private \PDO $conn;

    public function __construct() {
        // Lấy PDO connection từ Database
        $db = new Database();
        $this->conn = $db->connect();
    }

    /** Lấy toàn bộ đồ uống */
    public function getAll(): array {
        $stmt = $this->conn->prepare("SELECT * FROM drinks");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
