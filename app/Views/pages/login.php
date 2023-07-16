<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';

use App\Models\Database;
use App\Models\LoginModel;
use App\Controllers\LoginController;

$db = new Database('db_garage');
$loginModel = new LoginModel($db);
$loginController = new LoginController($loginModel);

$form = $loginController->index();
$loginForm = $form['loginForm'];

$loginController->processLoginForm();
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

            <?php echo $loginForm; ?>
            <?php if (isset($loginController) && !empty($loginController->getErrorMessage())) : ?>
                <div class="alert alert-danger"><?php echo $loginController->getErrorMessage(); ?></div>
            <?php endif; ?>
        </div>
    </div>
</main>