<?php
namespace App\Controllers;

use App\Services\FeedbackService;

class FeedbackController {
    private $feedbackService;
    public function __construct() {
        $this->feedbackService = new FeedbackService();
    }

    // API thêm phản hồi (gửi từ khách hàng)
    public function addFeedback() {
        // Dữ liệu gửi lên (POST)
        $userId = $_POST['user_id'] ?? 0;
        $drinkId = $_POST['drink_id'] ?? 0;
        $comment = $_POST['comment'] ?? '';
        $rating = $_POST['rating'] ?? null;
        $success = $this->feedbackService->addFeedback($userId, $drinkId, $comment, $rating);
        echo json_encode(["success" => $success]);
    }

    // API lấy feedback của một đồ uống
    public function getFeedbackByDrink() {
        $drinkId = $_GET['drink_id'] ?? 0;
        $list = $this->feedbackService->getFeedbackByDrink($drinkId);
        echo json_encode($list);
    }
}
?>
