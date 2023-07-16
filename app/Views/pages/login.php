<?php

use App\Models\Database;
use App\Models\FormCreator;
use App\Controllers\CookieManager;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';

// Autres instructions et utilisations de classes

// Démarrer la session
session_start();

// Créer formulaire loginForm
$loginForm = new FormCreator();
$loginForm->addField('username', 'text', 'Nom :');
$loginForm->addField('password', 'password', 'Mot de passe :');

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $loginForm->clearInput($_POST['username']) : '';
    $password = isset($_POST['password']) ? $loginForm->clearInput($_POST['password']) : '';

    // Connection à la DB
    $db = new Database('db_garage');

    $stmt = $db->getPDO()->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Traitement du formulaire de connexion
    if (!empty($users)) {
        $user = $users[0];
        if (password_verify($password, $user->password)) {
            if ($user->role == 1) {
                // Utilisateur administrateur
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $username;
                CookieManager::setLoggedInCookie($username);
            } else {
                // Utilisateur employé
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'employee';
                $_SESSION['username'] = $username;
                CookieManager::setLoggedInCookie($username);
            }

            header('Location: backoffice.php');
            exit();
        }
    }

    echo 'Identifiants incorrects. Veuillez réessayer.';
}
?>

<style>
    html,
    body {
        height: 100%;
    }

    main {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
</style>

<main>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="text-center">
            <h2>Connectez-vous</h2>

            <?php
            // Afficher le formulaire de connexion
            echo $loginForm->generateForm('conectBtn', 'Se connecter');
            ?>
        </div>
    </div>
</main>