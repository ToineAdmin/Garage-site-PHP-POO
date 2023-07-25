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

    public function getAllUsersWithMedia()
    {
        $sql = "SELECT u.*, m.path AS image_path FROM users u LEFT JOIN media m ON u.id = m.user_id";
        $stmt = $this->db->getPDO()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function getUserDataById($userId)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editUser'])) {
            $userId = $_POST["userId"];
        }
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

  


    public function addUser($email, $password, $role, $job)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO users (email, password, role, job) VALUES (:email, :password, :role, :job)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
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

    public function updateUser($userId, $email, $password, $role, $job)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE users SET email = :email, password = :password, role = :role, job = :job WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':job', $job, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getLastInsertId()
    {
        // Récupérer l'ID du dernier enregistrement inséré
        return $this->db->getPDO()->lastInsertId();
    }


    public function checkemail($email)
    {

        // Exécute la requête avec l'email en tant que paramètre
        $stmt = $this->db->getPDO()->prepare("SELECT COUNT(*) as count FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        // Récupère le résultat de la requête
        $result = $stmt->fetch();

        // Vérifie si le nombre d'enregistrements retourné est supérieur à 0
        if ($result['count'] > 0) {
            return true; // l'email existe déjà
        } else {
            return false; // l'email n'existe pas
        }
    }
}
