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
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Dans votre modèle de média (MediaModel)

    public function updateUserImg($imageName, $imagePath, $userId)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE users SET image_name = :imageName, image_path = :imagePath WHERE id = :userId");
        $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
        $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    
    public function deleteUserImg($userId)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM media WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserImg($userId)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM media WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }






//     public function addCarImg($name, $path, $carId)
//     {
//         $stmt = $this->db->getPDO()->prepare("INSERT INTO media (name, path, car_id) VALUES (:name, :path, :carId)");
//         $stmt->bindValue(':name', $name, PDO::PARAM_STR);
//         $stmt->bindValue(':path', $path, PDO::PARAM_STR);
//         $stmt->bindValue(':carid', $carId, PDO::PARAM_INT);
//         $stmt->execute();
//     }

//     public function getCarImg($carId)
//     {
//         $stmt = $this->db->getPDO()->prepare("SELECT * FROM media WHERE car_id = :carId");
//         $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
//         $stmt->execute();
//         return $stmt->fetch(PDO::FETCH_OBJ);
//     }

//     public function updateCarImg($imageName, $imagePath, $carId)
//     {
//         $stmt = $this->db->getPDO()->prepare("UPDATE users SET image_name = :imageName, image_path = :imagePath WHERE id = :carId");
//         $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
//         $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
//         $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
//         $stmt->execute();
//     }

//     public function deleteCarImg($carId)
//     {
//         $stmt = $this->db->getPDO()->prepare("DELETE FROM media WHERE user_id = :carId");
//         $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
//         $stmt->execute();
//     }
}
