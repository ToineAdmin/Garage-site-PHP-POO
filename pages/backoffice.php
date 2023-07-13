<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'admin') {
        // CONTENU ADMINITRATEUR
        echo "Bienvenue, administrateur !";
    } elseif ($_SESSION['role'] === 'employee') {
        //CONTENU EMPLOYE
        echo "Bienvenue, employé !";
    }

} else {

    //redirection si l'utilisateur n'est pas connecté 
    header('Location: ../pages/login.php');
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require '../pages/templates/header.php';


?>
