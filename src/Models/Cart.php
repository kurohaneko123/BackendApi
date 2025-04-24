<?php
namespace App\Models;

use Database;

class Cart {
    private $conn;
    public function __construct() {
        $db = new \Database();
        $this->conn = $db->connect();
    }

    // Thêm một mục vào giỏ hàng (cart) cho một order
    public function add($orderId, $drinkId, $quantity) {
        $query = "INSERT INTO cart (order_id, drink_id, quantity) VALUES (:oid, :did, :qty)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':oid', $orderId);
        $stmt->bindParam(':did', $drinkId);
        $stmt->bindParam(':qty', $quantity);
        return $stmt->execute();
    }

    // Lấy tất cả các item trong giỏ hàng của một đơn hàng
    public function getByOrder($orderId) {
        $query = "SELECT * FROM cart WHERE order_id = :oid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':oid', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
