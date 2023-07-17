<?php

namespace App\Models;

use PDO;
use App\Models\Database;

class MediaModel
{

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addUserImg($name, $path, $userId)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO media (name, path, user_id) VALUES (:name, :path, :user_id)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':path', $path, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $stmt->execute();
    }
}
