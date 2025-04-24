<?php
namespace App\Controllers;

use App\Services\UserService;

class UserController {
    private $userService;
    public function __construct() {
        $this->userService = new UserService();
    }

    // API đăng ký người dùng mới
    public function registerUser() {
        // Giả định dữ liệu gửi lên bằng phương thức POST (hoặc JSON)
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $result = $this->userService->registerUser($name, $email, $pass);
        echo json_encode($result);
    }

    // API đăng nhập
    public function loginUser() {
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $result = $this->userService->loginUser($email, $pass);
        echo json_encode($result);
    }
}
?>
