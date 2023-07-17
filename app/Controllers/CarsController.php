<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\MediaModel;
use App\Models\FormCreator;
use App\Controllers\MediasController;


class CarsController
{
    private $carModel;
    private $formCreator;
    private $errorMessage;
    private $mediaModel;
    private $mediasController;

    public function __construct(CarModel $carModel, MediaModel $mediaModel, MediasController $mediasController)
    {
        $this->carModel = $carModel;
        $this->mediaModel = $mediaModel;
        $this->mediasController = $mediasController;
        $this->formCreator = new FormCreator();
    }

    public function carsIndex()
    {
        // Récupération des voitures depuis le modèle
        $carsData = $this->carModel->getAllCarsWithMedia();

        // Création du formulaire d'ajout voiture
        $addCarForm = $this->createAddCarForm();

        // Récupération du formulaire de modification voiture
        $editCarForm = $this->createEditCarForm($carsData);

        // Retourner les données nécessaires à la vue
        return [
            'carsData' => $carsData,
            'addCarForm' => $addCarForm,
            'editCarForm' => $editCarForm,
        ];
    }

    private function createAddCarForm()
    {
        $carForm = new FormCreator();
        $carForm->addField('name', 'text', 'Nom');
        $carForm->addField('brand', 'text', 'Marque');
        $carForm->addField('year', 'text', 'Année de mise en circulation');
        $carForm->addField('price', 'text', 'Prix');
        $carForm->addField('miles', 'text', 'Kilométrage');
        $carForm->addField('description', 'textarea', 'Description');
        $carForm->addField('caracteristics', 'textarea', 'Caractéristiques(Boite de vitesse, Nombres de places, Nombre de portes');
        $carForm->addField('equipement', 'textarea', 'Equipements(Climatisation, Mode, etc.');
        $carForm->addField('addImgCar', 'image', 'Image', true);

        return $carForm->generateForm('addCar', 'Ajouter', true);
    }

    private function createEditCarForm()
    {
        $carForm = new FormCreator();
        $carForm->addField('name', 'text', 'Nom');
        $carForm->addField('brand', 'text', 'Marque');
        $carForm->addField('year', 'text', 'Année de mise en circulation (AAAA)');
        $carForm->addField('price', 'text', 'Prix');
        $carForm->addField('miles', 'text', 'Kilométrage');
        $carForm->addField('description', 'textarea', 'Description');
        $carForm->addField('caracteristics', 'textarea', 'Caractéristiques(Boite de vitesse, Nombres de places, Nombre de portes');
        $carForm->addField('equipement', 'textarea', 'Equipements(Climatisation, Mode, etc.)');
        $carForm->addField('editImgCar', 'image', 'Image', true);

        return $carForm->generateForm('updateCar', 'Modifier', true);
    }


    public function addCarSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCar'])) {
            $name = $this->formCreator->clearInput($_POST['name']);
            $brand = $this->formCreator->clearInput($_POST['brand']);
            $year = $this->formCreator->clearInput($_POST['year']);
            $price = $this->formCreator->clearInput($_POST['price']);
            $miles = $this->formCreator->clearInput($_POST['miles']);
            $description = $this->formCreator->clearInput($_POST['description']);
            $caracteristics = $this->formCreator->clearInput($_POST['caracteristics']);
            $equipement = $this->formCreator->clearInput($_POST['equipement']);

            // Vérification de l'existence du nom de voiture
            if ($this->carModel->checkCarName($name)) {
                $this->errorMessage = 'Ce nom de voiture existe déjà.';
                return;
            }
            // Vérification de la longueur du nom et de la marque
            if (strlen($name) > 50 || strlen($brand) > 50) {
                $this->errorMessage = 'Le nom et la marque ne doivent pas dépasser 50 caractères.';
                return;
            }

            // Vérification de l'année (doit être un entier à 4 chiffres)
            if (!is_numeric($year) || strlen($year) !== 4 || intval($year) <= 0) {
                $this->errorMessage = 'L\'année doit être un entier à 4 chiffres.';
                return;
            }

            // Vérification du prix (doit être un entier à 6 chiffres)
            if (!is_numeric($price) || strlen($price) > 6 || intval($price) <= 0) {
                $this->errorMessage = 'Le prix doit être un entier à 6 chiffres.';
                return;
            }

            // Vérification des miles (doit être un entier à 7 chiffres)
            if (!is_numeric($miles) || strlen($miles) > 7 || intval($miles) <= 0) {
                $this->errorMessage = 'Les miles doivent être un entier à 7 chiffres.';
                return;
            }

            // Vérification de la longueur de la description, des caractéristiques et de l'équipement
            if (strlen($description) > 200 || strlen($caracteristics) > 200 || strlen($equipement) > 200) {
                $this->errorMessage = 'La description, les caractéristiques et l\'équipement ne doivent pas dépasser 200 caractères.';
                return;
            }



            $name = ucfirst($name);

            // Ajouter la voiture dans la table "cars"
            $this->carModel->addCar($name, $brand, $year, $price, $miles, $description, $caracteristics, $equipement);

            // Récupérer l'ID de la voiture inséré
            $carId = $this->carModel->getLastInsertCarId();

            // Gérer le téléchargement de l'image
            $this->mediasController->uploadCarImage($carId, 'addImgCar');

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }




    public function deleteCarSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCar'])) {
            $carId = $_POST['carId'];

            $this->carModel->deleteCar($carId);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function updateCarSubmit()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCar'])) {
            $carId = $_POST['carId'];
            $name = $this->formCreator->clearInput($_POST['name']);
            $brand = $this->formCreator->clearInput($_POST['brand']);
            $year = $this->formCreator->clearInput($_POST['year']);
            $price = $this->formCreator->clearInput($_POST['price']);
            $miles = $this->formCreator->clearInput($_POST['miles']);
            $description = $this->formCreator->clearInput($_POST['description']);
            $caracteristics = $this->formCreator->clearInput($_POST['caracteristics']);
            $equipement = $this->formCreator->clearInput($_POST['equipement']);

            // Vérification de la longueur du nom et de la marque
            if (strlen($name) > 50 || strlen($brand) > 50) {
                $this->errorMessage = 'Le nom et la marque ne doivent pas dépasser 50 caractères.';
                return;
            }

            // Vérification de l'année (doit être un entier à 4 chiffres)
            if (!is_numeric($year) || strlen($year) !== 4 || intval($year) <= 0) {
                $this->errorMessage = 'L\'année doit être un entier à 4 chiffres.';
                return;
            }

            // Vérification du prix (doit être un entier à 6 chiffres)
            if (!is_numeric($price) || strlen($price) > 6 || intval($price) <= 0) {
                $this->errorMessage = 'Le prix doit être un entier à 6 chiffres.';
                return;
            }

            // Vérification des miles (doit être un entier à 7 chiffres)
            if (!is_numeric($miles) || strlen($miles) > 7 || intval($miles) <= 0) {
                $this->errorMessage = 'Les miles doivent être un entier à 7 chiffres.';
                return;
            }

            // Vérification de la longueur de la description, des caractéristiques et de l'équipement
            if (strlen($description) > 200 || strlen($caracteristics) > 200 || strlen($equipement) > 200) {
                $this->errorMessage = 'La description, les caractéristiques et l\'équipement ne doivent pas dépasser 200 caractères.';
                return;
            }


            $this->carModel->updateCar($carId, $name, $brand, $year, $price, $miles, $description, $caracteristics, $equipement);

            $this->mediasController->uploadCarImage($carId, 'editImgCar');

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
