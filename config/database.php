<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private string $host;
    private int $port;
    private string $db_name;
    private string $username;
    private string $password;
    private ?PDO $conn = null;

    public function __construct() {
        // Đọc từ biến môi trường, nếu không có sẽ dùng mặc định
        $this->host     = getenv('DB_HOST')     ?: 'turntable.proxy.rlwy.net';
        $this->port     = intval(getenv('DB_PORT')     ?: '29968');
        $this->db_name  = getenv('DB_NAME')     ?: 'railway';
        $this->username = getenv('DB_USERNAME') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: 'tuvsnycqhQmVsVDcUGdRpkoBkURjJAoT';
    }

    public function connect(): PDO {
        if ($this->conn) {
            return $this->conn;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $this->host, $this->port, $this->db_name
        );

        try {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            return $this->conn;
        } catch (PDOException $e) {
            error_log('[Database] Connection failed: ' . $e->getMessage());
            throw new \RuntimeException('Database Connection Failed');
        }
    }
}
