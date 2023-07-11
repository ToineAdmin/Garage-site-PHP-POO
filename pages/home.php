<?php
$title = 'Garage V.PARROT';
require '../pages/templates/header.php';

use App\Cars;
use App\Users;
use App\Services;
use App\ContactForm;



?>
<main>
    <section class="py-5 text-center container" id="home">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Garage V.PARROT</h1>
                <p class="lead text-body-secondary">Un garage à l'écoute, compétent et disponible !</p>
                <p>
                    <a href="#" class="btn btn-primary my-2">Nos occasions</a>
                    <a href="#" class="btn btn-secondary my-2">Nous contacter</a>
                </p>
            </div>
        </div>
    </section>
    <section id="services">
        <div class="container py-4">
            <div class="row align-items-md-stretch">
                <?php

                $data = $db->query('SELECT * FROM services');

                $services = new Services();

                foreach ($data as $row) {
                    $serviceName = $row->name;
                    $services->displayServices($serviceName);
                }
                ?>
            </div>
    </section>
    <section class="container" id="occasions">
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="text-center mb-lg-5">NOS VOITURE D'OCCASIONS</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php

                    //affiche en fonction de la base de données les voitures

                    $data = $db->query('SELECT * FROM cars');

                    $cars = new Cars();

                    foreach ($data as $row) {
                        $carsName = $row->brand;
                        $cars->displayCars($carsName);
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="container marketing mb-lg-5" id="about">
        <div class="row">
            <h2 class="text-center mb-lg-5 mt-lg-5">Qui sommes nous ?</h2>
            <?php

            //affiche en fonction de la base de données les utilisateurs du site à savoir les employés dans ce cas
            $data = $db->query('SELECT * FROM users');

            $users = new Users();

            foreach ($data as $row) {
                $username = $row->username;
                $users->displayUsers($username);
            }

            ?>
        </div>
    </section>


    <section class="container" id="contact">
        <div class="row">
            <h2 class="text-center">CONTACT</h2>
        </div>
        <div class="row">
        <?php
            // Traitement du formualire
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Récupérer les données du formulaire
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $message = $_POST["message"];

                    // Créer une instance du formulaire de contact
                    $contactForm = new ContactForm($name, $email, $message);

                    //Sécuriser les inputs
                    $name = $contactForm->sanitizeInput($name);
                    $email = $contactForm->sanitizeInput($email);
                    $message = $contactForm->sanitizeInput($message);
                
                    // Traiter le formulaire
                    $contactForm->processForm();
                    
                }
                
            ?>
            <form method="POST" action="">
                <div class="mb-3 w-25">
                    <label for="name" class="form-label">Nom :</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3 w-25">
                    <label for="email" class="form-label">E-mail :</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3 w-50">
                    <label for="message" class="form-label">Message :</label>
                    <textarea id="message" name="message" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>


        </div>
    </section>
</main>

<?php


require '../pages/templates/footer.php';
?>