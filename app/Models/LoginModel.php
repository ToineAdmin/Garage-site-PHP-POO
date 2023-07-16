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

    public function getUsers($username)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);

    }
    

}
