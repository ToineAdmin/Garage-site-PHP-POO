<?php

namespace App;

use PDO;

class Users
{

    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function displayUsers($username)
    {
        $html = '
        <div class="col-lg-4 mx-auto text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
            </svg>
            <h2 class="fw-normal">' . $username . '</h2>
            <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
        </div>';

        return $html;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $password, $role)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_INT);
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
        var_dump($userId, $username, $password, $role); // Afficher les valeurs des paramètres pour vérification
    
        $stmt = $this->db->getPDO()->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    }
    
}
