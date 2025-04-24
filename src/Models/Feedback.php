<?php
namespace App\Models;

use Database;

class Feedback {
    private $conn;
    public function __construct() {
        $db = new \Database();
        $this->conn = $db->connect();
    }

    // Thêm phản hồi mới
    public function add($userId, $drinkId, $comment, $rating) {
        $query = "INSERT INTO feedback (user_id, drink_id, comment, rating) 
                  VALUES (:uid, :did, :cmt, :rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $userId);
        $stmt->bindParam(':did', $drinkId);
        $stmt->bindParam(':cmt', $comment);
        $stmt->bindParam(':rate', $rating);
        return $stmt->execute();
    }

    // Lấy tất cả feedback của một đồ uống
    public function getByDrink($drinkId) {
        $query = "SELECT f.id, f.comment, f.rating, f.user_id, u.name AS user_name 
                  FROM feedback f 
                  JOIN users u ON f.user_id = u.id
                  WHERE f.drink_id = :did";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':did', $drinkId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
