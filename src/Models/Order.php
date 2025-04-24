<?php
namespace App\Models;

use Database;

class Order {
    private $conn;
    public function __construct() {
        $db = new \Database();
        $this->conn = $db->connect();
    }

    // Tạo đơn hàng mới, trả về ID đơn hàng mới nếu thành công
    public function create($userId) {
        $query = "INSERT INTO orders (user_id) VALUES (:uid)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $userId);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();  // lấy ID của order vừa thêm
        }
        return false;
    }

    // Cập nhật tổng tiền cho đơn hàng
    public function updateTotal($orderId, $totalAmount) {
        $query = "UPDATE orders SET total = :total WHERE id = :oid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':total', $totalAmount);
        $stmt->bindParam(':oid', $orderId);
        return $stmt->execute();
    }

    // Lấy danh sách đơn hàng theo user (lịch sử đơn hàng của 1 người dùng)
    public function getByUser($userId) {
        $query = "SELECT * FROM orders WHERE user_id = :uid ORDER BY order_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
