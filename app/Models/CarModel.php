<?php

namespace App\Models;

use PDO;
use App\Models\Database;

class CarModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllCars()
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM cars");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    
    public function getCarDataById($carId)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editCar'])) {
            $carId = $_POST["carId"];
        }
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM cars WHERE id = :carId");
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    public function getAllCarsWithMedia()
    {
        $sql = "SELECT c.*, m.path AS image_path FROM cars c LEFT JOIN media m ON c.id = m.car_id";
        $stmt = $this->db->getPDO()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addCar($name, $brand, $year, $price, $miles, $description, $caracteristics, $equipement, $user_id)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO cars (name, brand, year, price, miles, description, caracteristics, equipement, user_id )
        VALUES (:name, :brand, :year, :price, :miles, :description, :caracteristics, :equipement, :user_id)");

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);
        $stmt->bindValue(':miles', $miles, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':caracteristics', $caracteristics, PDO::PARAM_STR);
        $stmt->bindValue(':equipement', $equipement, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteCar($carId)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM cars WHERE id = :id");
        $stmt->bindParam(':id', $carId);
        $stmt->execute();
    }

    public function updateCar($carId, $name, $brand, $year, $price, $miles, $description, $caracteristics, $equipement, $user_id)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE cars SET name = :name, brand = :brand, year = :year, price = :price, miles = :miles, description = :description, caracteristics = :caracteristics, equipement = :equipement, user_id = :user_id
        WHERE id = :id");
        $stmt->bindParam(':id', $carId);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':miles', $miles, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':caracteristics', $caracteristics, PDO::PARAM_STR);
        $stmt->bindParam(':equipement', $equipement, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getLastInsertCarId()
    {
        // Récupérer l'ID du dernier enregistrement inséré
        return $this->db->getPDO()->lastInsertId();
    }

    public function checkCarName($name)
    {
        // Exécutez la requête avec le nom de la voiture en tant que paramètre
        $stmt = $this->db->getPDO()->prepare("SELECT COUNT(*) as count FROM cars WHERE name = :name");
        $stmt->bindValue(':name', $name);
        $stmt->execute();

        // Récupérez le résultat de la requête
        $result = $stmt->fetch();

        // Vérifiez si le nombre d'enregistrements retourné est supérieur à 0
        if ($result['count'] > 0) {
            return true; // Le nom de la voiture existe déjà
        } else {
            return false; // Le nom de la voiture n'existe pas
        }
    }
}
