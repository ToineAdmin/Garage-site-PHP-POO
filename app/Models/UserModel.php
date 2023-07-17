<?php

namespace App\Models;

use PDO;
use App\Models\Database;

class UserModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function addUser($username, $password, $role, $job)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO users (username, password, role, job) VALUES (:username, :password, :role, :job)");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_INT);
        $stmt->bindValue(':job', $job, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteUser($userId)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    public function updateUser($userId, $username, $password, $role)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    }

    public function getLastInsertId()
    {
        // Récupérer l'ID du dernier enregistrement inséré
        return $this->db->getPDO()->lastInsertId();
    }


    public function checkUsername($username)
{

    // Exécutez la requête avec le nom d'utilisateur en tant que paramètre
    $stmt = $this->db->getPDO()->prepare("SELECT COUNT(*) as count FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();

    // Récupérez le résultat de la requête
    $result = $stmt->fetch();

    // Vérifiez si le nombre d'enregistrements retourné est supérieur à 0
    if ($result['count'] > 0) {
        return true; // Le nom d'utilisateur existe déjà
    } else {
        return false; // Le nom d'utilisateur n'existe pas
    }
}




}
