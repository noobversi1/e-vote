<?php
class Token
{
    private $conn;
    private $table_name = "token";

    public $id;
    public $token;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function generateTokens($jumlah)
    {
        $query = "INSERT INTO " . $this->table_name . " (token) VALUES (:token)";
        $stmt = $this->conn->prepare($query);

        for ($i = 0; $i < $jumlah; $i++) {
            $token = bin2hex(random_bytes(8));
            $stmt->bindParam(":token", $token);
            $stmt->execute();
        }
    }

    public function verifyToken($token)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE token = :token AND status = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function updateTokenStatus($token)
    {
        $query = "UPDATE " . $this->table_name . " SET status = 1 WHERE token = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
    }

    // Fungsi untuk membaca semua token dengan pagination
    public function readAll($limit, $offset)
    {
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $offset, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();

        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tokens;
    }

    // Fungsi untuk menghitung total token
    public function countAll()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
