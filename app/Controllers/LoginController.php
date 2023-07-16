<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\FormCreator;

class LoginController
{

    private $loginModel;
    private $formCreator;
    private $errorMessage;

    public function __construct(LoginModel $loginModel)
    {
        $this->loginModel = $loginModel;
        $this->formCreator = new FormCreator();
    }

    public function index()
    {

        $loginForm = $this->creatLoginForm();

        return [
            'loginForm' => $loginForm,
        ];
    }

    public function creatLoginForm()
    {
        $loginForm = new FormCreator();
        $loginForm->addField('username', 'text', 'Nom :');
        $loginForm->addField('password', 'password', 'Mot de passe :');

        return $loginForm->generateForm('conectBtn', 'Se connecter', true);
    }
    public function processLoginForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['conectBtn'])) {
            $username = $this->formCreator->clearInput($_POST['username']);
            $password = $this->formCreator->clearInput($_POST['password']);

            $user = $this->loginModel->getUsers($username);


            if ($user && password_verify($password, $user->password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = (intval($user->role) === 1) ? 'admin' : 'employee';
                $_SESSION['username'] = $username;
                CookieManager::setLoggedInCookie($username);

                header('Location: backoffice.php');
                exit();
            }

            $this->errorMessage = 'Identifiants incorrects. Veuillez réessayer.';
        }
    }


    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
