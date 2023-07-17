<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\FormCreator;

class ServicesController
{
    private $serviceModel;
    private $formCreator;
    private $errorMessage;

    public function __construct(ServiceModel $serviceModel)
    {
        $this->serviceModel = $serviceModel;
        $this->formCreator = new FormCreator();
    }

    public function serviceIndex()
    {
        // Récupération des utilisateurs depuis le modèle
        $servicesData = $this->serviceModel->getAllServices();

        // Création du formulaire d'ajout d'utilisateur
        $addServiceForm = $this->createAddServiceForm();

        // Récupération du formulaire de modification d'utilisateur
        $editServiceForm = $this->createEditServiceForm($servicesData);

        // Retourner les données nécessaires à la vue
        return [
            'servicesData' => $servicesData,
            'addServiceForm' => $addServiceForm,
            'editServiceForm' => $editServiceForm,
        ];
    }

    private function createAddServiceForm()
    {
        $serviceForm = new FormCreator();
        $serviceForm->addField('name', 'text', 'Nom du service');
        $serviceForm->addField('description', 'textarea', 'Description');

        return $serviceForm->generateForm('addService', 'Ajouter', true);
    }

    private function createEditServiceForm()
    {
        $serviceForm = new FormCreator();
        $serviceForm->addField('name', 'text', 'Nom du service');
        $serviceForm->addField('description', 'textarea', 'Description');

        return $serviceForm->generateForm('updateService', 'Modifier', true);
    }

    public function addServiceSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addService'])) {
            $name = $this->formCreator->clearInput($_POST['name']);
            $description = $this->formCreator->clearInput($_POST['description']);


            // Vérification de l'existence du nom d'utilisateur
            if ($this->serviceModel->checkServicename($name)) {
                $this->errorMessage = 'Ce service existe déjà.';
                return;
            }


            // Vérification du métier
            if (strlen($name) < 3 || strlen($name) > 30) {
                $this->errorMessage = 'Le service doit contenir entre 3 et 30 caractères.';
                return;
            }
            if (strlen($description) < 10 || strlen($description) > 200) {
                $this->errorMessage = 'La description doit contenir entre 10 et 100 caractères.';
                return;
            }

            $name = ucfirst($name);

            $this->serviceModel->addService($name, $description);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }


    public function deleteServiceSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteService'])) {
            $serviceId = $_POST['serviceId'];

            $this->serviceModel->deleteService($serviceId);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function updateServiceSubmit(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateService'])) {
            $serviceId = $_POST['serviceId'];
            $name = $this->formCreator->clearInput($_POST['name']);
            $description = $this->formCreator->clearInput($_POST['description']);

            $this->serviceModel->updateService($serviceId, $name, $description);
    
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
