<?php

namespace App\Views\Templates;

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
  <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="../public/css/style.css">
  <meta name="theme-color" content="#712cf9">
</head>

<body>


  <div class="container fixed-top">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
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
        echo '</ul>';

        ?>

      </nav>
      <div class="col-md-3 text-end">
        <?php

        // CHANGEMENT DE BUTTON SI CONNECTE OU NON CONNECTE

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          // Si connecté
          echo '<form action="logout.php" method="post">';
        } else {
          // Si non connecté
          echo '<form action="' . ($currentFile === 'login.php' ? 'login.php' : '../app/Views/pages/login.php') . '" method="get">';
        }

        echo '<button type="submit" class="btn btn-outline-primary me-2">' . (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'Se déconnecter' : 'Connectez-vous') . '</button>';
        echo '</form>';
        ?>

      </div>


    </header>


  </div>