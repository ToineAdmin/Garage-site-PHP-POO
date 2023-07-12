<?php
require_once __DIR__ . '/../vendor/autoload.php';
require '../pages/templates/header.php';


use App\FormCreator;
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
            // Créer formulaire loginForm
            $loginForm = new FormCreator();
            $loginForm->addField('username', 'text', 'Nom :');
            $loginForm->addField('password', 'password', 'Mot de passe :');

            // Afficher le formulaire de contact
            echo $loginForm->generateForm('Se connecter');
            ?>
        </div>
    </div>
</main>
