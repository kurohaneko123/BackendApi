<?php
namespace App\Services;

use App\Models\Feedback;

class FeedbackService {
    private $fbModel;
    public function __construct() {
        $this->fbModel = new Feedback();
    }

    // Thêm phản hồi mới
    public function addFeedback($userId, $drinkId, $comment, $rating) {
        return $this->fbModel->add($userId, $drinkId, $comment, $rating);
    }

    // Lấy danh sách feedback theo đồ uống
    public function getFeedbackByDrink($drinkId) {
        return $this->fbModel->getByDrink($drinkId);
    }
}
?>
