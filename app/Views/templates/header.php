<?php

namespace App\Views\Templates;

use App\Controllers\CookieManager;

$currentFile = basename($_SERVER['PHP_SELF']);

?>

<!doctype html>
<html lang="fr" data-bs-theme="auto">

<head>
  <script src="/docs/5.3/assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.112.5">

  <title><?= $title ?? 'Garage' ?></title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">
  <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="../public/css/style.css">
  <meta name="theme-color" content="#712cf9">
</head>

<body>

  <div class="container ">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 fixed-top">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
            <use xlink:href="#bootstrap" />
          </svg>
        </a>
      </div>
      <nav>
        <?php
        $currentFile = basename($_SERVER['PHP_SELF']);

        if ($currentFile === 'login.php' || $currentFile === 'backoffice.php') {
          $menuItems = array(
            'Accueil' => '../../../public/index.php#home',
            'Services' => '../../../public/index.php#services',
            'Occasions' => '../../../public/index.php#occasions',
            'Qui sommes nous?' => '../../../public/index.php#about',
            'Contact' => '../../../public/index.php#contact'
          );
        } else {
          $menuItems = array(
            'Accueil' => '../public/index.php#home',
            'Services' => '../public/index.php#services',
            'Occasions' => '../public/index.php#occasions',
            'Qui sommes nous?' => '../public/index.php#about',
            'Contact' => '../public/index.php#contact'
          );
        }

        echo '<ul class="nav nav-pills col-12 col-md-auto mb-2 justify-content-center mb-md-0">';
        foreach ($menuItems as $label => $url) {
          echo '<li class="nav-item"><a href="' . $url . '" class="nav-link">' . $label . '</a></li>';
        }
        // Afficher le bouton "Mon espace" uniquement si la session est active et le fichier actuel n'est pas backoffice.php


        // Vérifier si l'utilisateur est connecté en utilisant la classe CookieManager
        $isLoggedIn = CookieManager::isLoggedIn();

        if ($isLoggedIn && $currentFile !== 'backoffice.php') {
          echo '<li class="nav-item"><a href="../app/Views/pages/backoffice.php" class="nav-link">Mon espace</a></li>';
        }

        // Récupérer le nom du fichier actuel
        $currentFile = basename($_SERVER['PHP_SELF']);



        echo '</ul>';
        ?>

      </nav>
      <div class="col-md-3 text-end">
        <?php

        // Déterminer l'action du formulaire en fonction de la connexion et du fichier actuel
        $action = '';
        if ($isLoggedIn) {
          // Si connecté
          $action = ($currentFile === "backoffice.php") ? 'logout.php' : '../app/Views/pages/logout.php';
        } else {
          // Si non connecté
          $action = ($currentFile === 'login.php') ? 'login.php' : '../app/Views/pages/login.php';
        }

        // Déterminer le libellé du bouton en fonction de la connexion
        $buttonLabel = ($isLoggedIn) ? 'Se déconnecter' : 'Connectez-vous';

        // Afficher le formulaire
        echo '<form action="' . $action . '" method="post">';
        echo '<button type="submit" class="btn btn-outline-primary me-2">' . $buttonLabel . '</button>';
        echo '</form>';
        ?>

    </header>
  </div>

</body>
<style>
  header{
    display: flex;
    flex-wrap: nowrap;

  }
</style>
</html>