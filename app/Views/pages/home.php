<?php

use App\Controllers\CookieManager;


// Vérifier si l'utilisateur est connecté en utilisant la classe CookieManager
$isLoggedIn = CookieManager::isLoggedIn();

if ($isLoggedIn) {
    // Démarrer la session uniquement si l'utilisateur est connecté
    session_start();
}



$title = 'Garage V.PARROT';
require_once __DIR__ . '/../Templates/header.php';

use App\Models\UserModel;
use App\Models\ContactForm;
use App\Models\FormCreator;
use App\Models\ServiceModel;

use App\Controllers\UsersController;
use App\Controllers\ServicesController;

//Instance des classes
$userModel = new UserModel($db);
$usersController = new UsersController($userModel);

$serviceModel = new ServiceModel($db);
$servicesController = new ServicesController($serviceModel);

//Récupère les données
$data = $usersController->index();
$usersData = $data['usersData'];

$serviceData = $servicesController->Serviceindex();
$servicesData = $serviceData['servicesData'];

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
                <h2>Nos Services</h2>
                <?php foreach ($servicesData as $service) : ?>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 text-bg-dark rounded-3">
                        <h2><?php echo $service->name ?></h2>
                        <p><?php echo $service->description ?></p>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
    </section>

<!-- 
    <section class="container" id="occasions">
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="text-center mb-lg-5">NOS VOITURE D'OCCASIONS</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php

                    // //affiche en fonction de la base de données les voitures

                    // $stmt = $db->getPDO()->prepare("SELECT * FROM cars");
                    // $stmt->execute();
                    // $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // $cars = new Cars();

                    // foreach ($data as $row) {
                    //     $carsName = $row->brand;
                    //     $cars->displayCars($carsName);
                    // }
                    ?>
                </div>
            </div>
        </div>
    </section> -->
    <section class="container marketing mb-lg-5" id="about">
        <div class="row">
            <h2 class="text-center mb-lg-5 mt-lg-5">Qui sommes nous ?</h2>
            <?php foreach ($usersData as $user) : ?>
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
                    </svg>
                    <h2 class="fw-normal"><?php echo $user->username ?></h2>
                    <h5 class="fw-normal"><?php echo $user->job ?></h5>
                </div>
            <?php endforeach ?>
        </div>
    </section>






    <section class="container" id="contact">
        <div class="row">
            <h2 class="text-center">CONTACT</h2>
        </div>
        <div class="row contact-form container d-flex justify-content-center">
            <?php

            // Créer le formulaire de contact

            $contactForm = new FormCreator();
            $contactForm->addField('username', 'text', 'Nom :');
            $contactForm->addField('email', 'email', 'E-mail :');
            $contactForm->addField('message', 'textarea', 'Message :');

            // Afficher le formulaire de contact
            echo $contactForm->generateForm('messBtn', 'Envoyer');

            // Traitement du formualire
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupérer les données du formulaire
                $name = $_POST['name'];
                $email = $_POST['email'];
                $message = $_POST['message'];


                $contactForm = new ContactForm($name, $email, $message);

                // Sécuriser les inputs
                $name = $contactForm->clearInput($name);
                $email = $contactForm->clearInput($email);
                $message = $contactForm->clearInput($message);

                // Traiter le formulaire
                $contactForm->processForm();
            }



            ?>

        </div>
    </section>
</main>

<?php





require_once '../app/Views/Templates/footer.php';
?>