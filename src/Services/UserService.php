<?php
namespace App\Services;

use App\Models\User;

class UserService {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Đăng ký người dùng mới (KHÔNG mã hóa mật khẩu)
    public function registerUser($name, $email, $password) {
        $existing = $this->userModel->getByEmail($email);
        if ($existing) {
            return ["success" => false, "message" => "Email đã tồn tại!"];
        }

        // ✅ Lưu mật khẩu trực tiếp (plain text)
        $result = $this->userModel->create($name, $email, $password);

        if ($result) {
            $newUser = $this->userModel->getByEmail($email);
            if ($newUser) {
                unset($newUser['password']);
            }
            return ["success" => true, "user" => $newUser];
        }
        return ["success" => false, "message" => "Đăng ký thất bại"];
    }

    // Đăng nhập KHÔNG dùng password_verify
    public function loginUser($email, $password) {
        $user = $this->userModel->getByEmail($email);
        if ($user && $user['password'] === $password) {
            unset($user['password']);
            return ["success" => true, "user" => $user];
        }

        return ["success" => false, "message" => "Email hoặc mật khẩu không đúng"];
    }
}
?>
