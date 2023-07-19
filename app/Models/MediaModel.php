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





    public function addCarImg($name, $path, $carId)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO media (name, path, car_id) VALUES (:name, :path, :carId)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':path', $path, PDO::PARAM_STR);
        $stmt->bindValue(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function getMediaPathsByCarId($carId)
    {
        $sql = "SELECT path FROM media WHERE car_id = :carId";
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
        $mediaPaths = $stmt->fetchAll(PDO::FETCH_OBJ); 
        return $mediaPaths;
    }

    public function deleteDuplicatePaths($carId = null, $userId = null)
{
    $query = "SELECT path, COUNT(*) as count FROM media";

    if ($carId !== null) {
        $query .= " WHERE car_id = :carId";
        $bindParam = ':carId';
        $id = $carId;
    } elseif ($userId !== null) {
        $query .= " WHERE user_id = :userId";
        $bindParam = ':userId';
        $id = $userId;
    } else {
        // Si ni carId ni userId ne sont fournis, nous ne pouvons pas effectuer la comparaison des chemins
        return;
    }

    $query .= " GROUP BY path HAVING count > 1";

    $stmt = $this->db->getPDO()->prepare($query);
    $stmt->bindParam($bindParam, $id, PDO::PARAM_INT);
    $stmt->execute();
    $duplicatePaths = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (empty($duplicatePaths)) {
        // S'il n'y a pas de chemins en double, nous n'avons rien à supprimer
        return;
    }

    $inClause = implode(',', array_fill(0, count($duplicatePaths), '?'));

    $deleteStmt = $this->db->getPDO()->prepare("DELETE FROM media WHERE path IN ($inClause)");
    $deleteStmt->execute($duplicatePaths);
}




    public function getCarImg($carId)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM media WHERE car_id = :carId");
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateCarImg($imageName, $imagePath, $carId)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE cars SET image_name = :imageName, image_path = :imagePath WHERE id = :carId");
        $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
        $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteCarImg($carId)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM media WHERE car_id = :carId");
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
