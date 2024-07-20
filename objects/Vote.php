<?php
class Vote
{
    private $conn;
    private $table_name = "vote";

    public $id;
    public $token_id;
    public $calon_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function vote()
    {
        $query = "INSERT INTO " . $this->table_name . " SET token_id=:token_id, calon_id=:calon_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":token_id", $this->token_id, PDO::PARAM_INT);
        $stmt->bindParam(":calon_id", $this->calon_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
