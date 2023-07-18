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

use App\Models\MediaModel;
use App\Models\ServiceModel;
use App\Models\CarModel;
use App\Models\UserModel;
use App\Controllers\CarsController;
use App\Controllers\UsersController;
use App\Controllers\MediasController;
use App\Controllers\ServicesController;
use App\Controllers\ContactFormController;

//Instance des classes
$userModel = new UserModel($db);
$mediaModel = new MediaModel($db);
$carModel = new CarModel($db);
$mediasController = new MediasController($mediaModel);
$carsController = new CarsController($carModel, $mediaModel, $mediasController);
$usersController = new UsersController($userModel, $mediaModel, $mediasController);

$serviceModel = new ServiceModel($db);
$servicesController = new ServicesController($serviceModel);

//Récupère les données
$data = $usersController->index();
$usersData = $data['usersData'];

$data = $carsController->carsIndex();
$carsData = $data['carsData'];

$serviceData = $servicesController->Serviceindex();
$servicesData = $serviceData['servicesData'];

//variables pour contactForm
$name = '';
$email = '';
$message = '';

$contactFormController = new ContactFormController($name, $email, $message);
$contactForm = $contactFormController->createContactForm();
$contactFormController->contacFormSubmit();
?>
<main>

    <!-- SECTION ACCUEIL !-->
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

    <!-- SECTION SERVICES !-->
    <section id="services">
        <div class="container py-4">
            <div class="row align-items-md-stretch">
                <h2 class="text-center mb-5">Nos Services</h2>
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


    <section id="occasions">
        <h2 class="text-center">Nos voitures d'occasions</h2>
        <div class="container occas-container d-flex justify-content-center flex-wrap">
            <?php foreach ($carsData as $car) : ?>
                <div class="card">
                    <div id="carouselExample_<?php echo $car->id; ?>" class="carousel slide">
                        <div class="carousel-inner">
                            <?php
                            $mediaPaths = $mediaModel->getMediaPathsByCarId($car->id);
                            foreach ($mediaPaths as $index => $media) :
                                $imagePath = $media->path;
                                $isActive = ($index === 0) ? 'active' : '';
                            ?>
                                <div class="carousel-item <?php echo $isActive; ?>">
                                    <img src="../<?php echo $imagePath; ?>" class="d-block carousel-image" alt="Car Image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample_<?php echo $car->id; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample_<?php echo $car->id; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $car->name; ?></h5>
                        <p class="card-text"><?php echo $car->brand; ?></p>
                        <p class="card-text"><?php echo $car->price; ?> €</p>
                        <button class="btn btn-primary toggle-button" id="toggle-button_<?php echo $car->id; ?>" onclick="toggleDetails(this, '<?php echo $car->id; ?>')">En savoir plus</button>
                        <div class="details" id="details_<?php echo $car->id; ?>" style="display: none;">
                            <div class="table-container">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Kilomètres</th>
                                            <td><?php echo $car->miles; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Année de mise en circulation</th>
                                            <td><?php echo $car->year; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Description</th>
                                            <td><?php echo $car->description; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Caractéristiques</th>
                                            <td><?php echo $car->caracteristics; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Équipements</th>
                                            <td><?php echo $car->equipement; ?></td>
                                        </tr>
                                        <!-- Ajoutez plus de paires th/td ici pour plus de détails -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </section>






    <style>
        .card {
            transition: max-height 0.5s ease;
            overflow: hidden;
            height: 500px;
            min-width: 25vw;
            max-width: 25vw;
        }

        .card.active {
            height: auto;
            font-weight: normal;

        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .carousel-image {
            width: 100%;
            height: 300px;
            /* Remplacez par la hauteur souhaitée */
            object-fit: cover;
            /* Permet de conserver les proportions de l'image tout en la recadrant si nécessaire */
        }

        .occas-container {
            gap: 30px;
            /* Ajustez la valeur de l'espacement selon vos besoins */
        }
    </style>

    </section>

    <!-- SECTION QUI SOMMES NOUS !-->
    <section class="container marketing mb-lg-5" id="about">
        <div class="row">
            <h2 class="text-center mb-lg-5 mt-lg-5">Qui sommes nous ?</h2>
            <?php foreach ($usersData as $user) : ?>
                <div class="col-lg-4 img-container">
                    <svg class="bd-placeholder-img rounded-circle" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <image href="../<?php echo $user->image_path; ?>" width="200" height="200" preserveAspectRatio="xMidYMid slice" />
                    </svg>
                    <h2 class="fw-normal text-center"><?php echo $user->username ?></h2>
                    <h5 class="fw-normal text-center"><?php echo $user->job ?></h5>
                </div>
            <?php endforeach ?>
        </div>
    </section>
    <style>
        .img-container {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .img-container svg {
            margin: 0 auto;
        }
    </style>


    <!-- SECTION CONTACT !-->
    <section class="container" id="contact">
        <div class="row">
            <h2 class="text-center">CONTACT</h2>
        </div>
        <div class="row contact-form container d-flex justify-content-center">
            <div class="w-25">
                <?php echo $contactForm ?>
            </div>
        </div>
    </section>

</main>

<?php
require_once '../app/Views/Templates/footer.php';
?>