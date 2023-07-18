<?php

namespace App\Models;

use PDO;
use App\Models\Database;

class LoginModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUsers($email)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
