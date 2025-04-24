<?php
namespace App\Models;

use Database;

class User {
    private $conn;

    public function __construct() {
        $db = new \Database(); // Kết nối database từ lớp Database
        $this->conn = $db->connect();
    }

    // Lấy user theo email (dùng cho đăng nhập và kiểm tra trùng)
    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Tạo người dùng mới (đăng ký)
    public function create($name, $email, $password) {
        $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :pass, 'customer')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $password);
        return $stmt->execute();
    }
}
?>
