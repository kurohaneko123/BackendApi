<?php
namespace App\Models;

use App\Config\Database; // ← import đúng namespace

class Drink {
    private $conn;

    public function __construct() {
        // Khởi tạo kết nối bằng lớp Database trong namespace App\Config
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll(): array {
        $query = "SELECT * FROM drinks";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
