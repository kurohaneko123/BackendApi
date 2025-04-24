<?php
namespace App\Models;

use Database;

class Drink {
    private $conn;
    
    public function __construct() {
        // Khởi tạo kết nối cơ sở dữ liệu thông qua lớp Database trong namespace App\Config
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $query = "SELECT * FROM drinks";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
