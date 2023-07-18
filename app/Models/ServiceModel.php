<?php

namespace App\Models;

use PDO;
use App\Models\Database;


class ServiceModel
{

    private $db;


    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function displayServices($reparation)
    {

        echo
        '<div class="col-md-6 mb-3">
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2>' . $reparation . '</h2>
                <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
                <button class="btn btn-outline-light" type="button">Example button</button>
            </div>
        </div>';
    }

    public function getAllServices()
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM services");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addService($name, $description)
    {
        $stmt = $this->db->getPDO()->prepare("INSERT INTO services (name, description) VALUES (:name, :description)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteService($serviceId)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM services WHERE id = :id");
        $stmt->bindParam(':id', $serviceId);
        $stmt->execute();
    }

    public function updateService($serviceId, $name, $description)
    {
        $stmt = $this->db->getPDO()->prepare("UPDATE services SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $serviceId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function checkServiceName($name)
    {

        // Exécutez la requête avec l'email en tant que paramètre
        $stmt = $this->db->getPDO()->prepare("SELECT COUNT(*) as count FROM services WHERE name = :name");
        $stmt->bindValue(':name', $name);
        $stmt->execute();

        // Récupérez le résultat de la requête
        $result = $stmt->fetch();

        // Vérifiez si le nombre d'enregistrements retourné est supérieur à 0
        if ($result['count'] > 0) {
            return true; // l'email existe déjà
        } else {
            return false; // l'email n'existe pas
        }
    }
}
