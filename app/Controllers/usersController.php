<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FormCreator;

class UsersController
{
    private $userModel;
    private $formCreator;
    private $errorMessage;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
        $this->formCreator = new FormCreator();
    }

    public function index()
    {
        // Récupération des utilisateurs depuis le modèle
        $usersData = $this->userModel->getAllUsers();

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

        return $userForm->generateForm('addUser', 'Ajouter', true);
    }

    private function createEditUserForm($userData)
    {
        $userForm = new FormCreator();
        $userForm->addField('username', 'text', 'Nom d\'utilisateur');
        $userForm->addField('password', 'password', 'Mot de passe');
        $userForm->addField('role', 'text', 'Rôle');
        $userForm->addField('job', 'text', 'Métier');

        // Pré-remplir les champs avec les données de l'utilisateur
        $userForm->setValues($userData);

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
            $this->userModel->addUser($username, $securedPassword, $role, $job);
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

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
