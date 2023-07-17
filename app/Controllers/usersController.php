<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MediaModel;
use App\Models\FormCreator;
use App\Controllers\MediasController;


class UsersController
{
    private $userModel;
    private $formCreator;
    private $errorMessage;
    private $mediaModel;
    private $mediasController;

    public function __construct(UserModel $userModel, MediaModel $mediaModel, MediasController $mediasController)
    {
        $this->userModel = $userModel;
        $this->mediaModel = $mediaModel;
        $this->mediasController = $mediasController;
        $this->formCreator = new FormCreator();
    }

    public function index()
    {
        // Récupération des utilisateurs depuis le modèle
        $usersData = $this->userModel->getAllUsersWithMedia();

        // Création du formulaire d'ajout d'utilisateur
        $addUserForm = $this->createAddUserForm();

        // Récupération du formulaire de modification d'utilisateur
        $editUserForm = $this->createEditUserForm($usersData);

        // Retourner les données nécessaires à la vue
        return [
            'usersData' => $usersData,
            'addUserForm' => $addUserForm,
            'editUserForm' => $editUserForm,
        ];
    }

    private function createAddUserForm()
    {
        $userForm = new FormCreator();
        $userForm->addField('username', 'text', 'Nom d\'utilisateur');
        $userForm->addField('password', 'password', 'Mot de passe');
        $userForm->addField('role', 'text', 'Rôle');
        $userForm->addField('job', 'text', 'Métier');
        $userForm->addField('addImgUser', 'image', 'Image');

        return $userForm->generateForm('addUser', 'Ajouter', true);
    }

    private function createEditUserForm()
    {
        $userForm = new FormCreator();
        $userForm->addField('username', 'text', 'Nom d\'utilisateur');
        $userForm->addField('password', 'password', 'Mot de passe');
        $userForm->addField('role', 'text', 'Rôle');
        $userForm->addField('job', 'text', 'Métier');
        $userForm->addField('editImgUser', 'image', 'Image');

        return $userForm->generateForm('updateUser', 'Modifier', true);
    }


    public function addUserSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addUser'])) {
            $username = $this->formCreator->clearInput($_POST['username']);
            $password = $this->formCreator->clearInput($_POST['password']);
            $role = $this->formCreator->clearInput($_POST['role']);
            $job = $this->formCreator->clearInput($_POST['job']);

            // Vérification de l'existence du nom d'utilisateur
            if ($this->userModel->checkUsername($username)) {
                $this->errorMessage = 'Ce nom d\'utilisateur existe déjà.';
                return;
            }

            // Vérification du mot de passe 
            if (!preg_match('/[A-Z]/', $password) || strlen($password) < 8) {
                $this->errorMessage = 'Le mot de passe doit contenir au moins une majuscule et avoir au moins 8 caractères';
                return;
            }

            // Vérification du rôle 
            if ($role !== '1' && $role !== '2') {
                $this->errorMessage = 'Le rôle doit être égal à 1 ou 2.';
                return;
            }

            // Vérification du métier
            if (strlen($job) < 3 || strlen($job) > 30) {
                $this->errorMessage = 'Le métier doit contenir entre 3 et 30 caractères.';
                return;
            }

            $securedPassword = password_hash($password, PASSWORD_DEFAULT);

            $username = ucfirst($username);

            // Ajouter l'utilisateur dans la table "users"
            $this->userModel->addUser($username, $securedPassword, $role, $job);

            // Récupérer l'ID de l'utilisateur inséré
            $userId = $this->userModel->getLastInsertId();

            // Gérer le téléchargement de l'image
            $this->mediasController->uploadImage($userId, 'addImgUser');

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }



    public function deleteUserSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUser'])) {
            $userId = $_POST['userId'];

            $this->userModel->deleteUser($userId);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function updateUserSubmit()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateUser'])) {
            $userId = $_POST['userId'] ; 
            $username = $this->formCreator->clearInput($_POST['username']);
            $password = $this->formCreator->clearInput($_POST['password']);
            $role = $this->formCreator->clearInput($_POST['role']);
            $job = $this->formCreator->clearInput($_POST['job']);



            // Vérification du mot de passe 
            if (!preg_match('/[A-Z]/', $password) || strlen($password) < 8) {
                $this->errorMessage = 'Le mot de passe doit contenir au moins une majuscule et avoir au moins 8 caractères';
                return;
            }

            // Vérification du rôle 
            if ($role !== '1' && $role !== '2') {
                $this->errorMessage = 'Le rôle doit être égal à 1 ou 2.';
                return;
            }

            // Vérification du métier
            if (strlen($job) < 3 || strlen($job) > 30) {
                $this->errorMessage = 'Le métier doit contenir entre 3 et 30 caractères.';
                return;
            }

            $securedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->updateUser($userId, $username, $securedPassword, $role, $job);



            // Gérer le téléchargement de l'image
            $this->mediasController->uploadImage($userId, 'editImgUser');

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
