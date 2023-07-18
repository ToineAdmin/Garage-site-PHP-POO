<?php
session_start();


require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';

use App\Models\CarModel;
use App\Models\Database;
use App\Models\UserModel;
use App\Models\MediaModel;
use App\Models\ServiceModel;
use App\Controllers\CarsController;
use App\Controllers\UsersController;
use App\Controllers\MediasController;
use App\Controllers\ServicesController;

//Instance des objets
$db = new Database('db_garage');
$mediaModel = new MediaModel($db);
$userModel = new UserModel($db);
$carModel = new CarModel($db);
$mediasController = new MediasController($mediaModel);
$usersController = new UsersController($userModel, $mediaModel, $mediasController);
$carsController = new CarsController($carModel, $mediaModel, $mediasController);

$serviceModel = new serviceModel($db);
$servicesController = new servicesController($serviceModel);

//Récupère les données users
$data = $usersController->index();
$usersData = $data['usersData'];
$addUserForm = $data['addUserForm'];
$editUserForm = $data['editUserForm'];

//Récupère les données cars
$data = $carsController->carsIndex();
$carsData = $data['carsData'];
$addCarForm = $data['addCarForm'];
$editCarForm = $data['editCarForm'];


//Récupère les données services
$data = $servicesController->serviceIndex();
$servicesData = $data['servicesData'];
$addServiceForm = $data['addServiceForm'];
$editServiceForm = $data['editServiceForm'];


//Traitement de formulaire users
$usersController->addUserSubmit();
$usersController->deleteUserSubmit();
$usersController->updateUserSubmit();

//Traitement de formulaire cars
$carsController->addCarSubmit();
$carsController->deleteCarSubmit();
$carsController->updateCarSubmit();

//Traitement de formulaire service
$servicesController->addServiceSubmit();
$servicesController->deleteServiceSubmit();
$servicesController->updateServiceSubmit();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);







?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'admin') : ?>

    <main>
        <h2 class="my-5 text-center">Bienvenue dans votre espace d'administation <?= $_SESSION['email'] ?></h2>

        <!-- Tableau des utilisateurs -->
        <section class="container my-5">
            <h3>Utilisateurs</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Rôle</th>
                        <th>Métier</th>
                        <th>Profil</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersData as $user) : ?>
                        <tr>
                            <td><?php echo $user->email; ?></td>
                            <td><?php echo $user->password; ?></td>
                            <td><?php echo $user->role; ?></td>
                            <td><?php echo $user->job; ?></td>
                            <td>
                                <?php if (!empty($user->image_path)) : ?>
                                    <img src="../../../<?php echo $user->image_path; ?>" alt="Photo de profil" width="50">
                                <?php else : ?>
                                    <span>Aucune image</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="userId" value="<?php echo $user->id; ?>">
                                    <button type="submit" class="btn btn-primary" name="editUser">Modifier</button>
                                </form>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="userId" value="<?php echo $user->id; ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteUser">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>



            <?php if (isset($usersController) && !empty($usersController->getErrorMessage())) : ?>
                <div class="alert alert-danger"><?php echo $usersController->getErrorMessage(); ?></div>
            <?php endif; ?>


            <form action="" method="POST">
                <button type="submit" class="btn btn-primary" name="addUsers">Ajouter</button>
            </form>
            <?php

            $showAddUserForm = '';
            if (isset($_POST['addUsers'])) {
                $showAddUserForm = true;
                // Différence : Suppression de la balise card-body avec la classe m-auto
                echo '<div class="card card-body w-25 m-auto">';
            } else if (isset($_POST['editUser'])) {
                $showAddUserForm = false;
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'editUser_') !== false) {
                        $userId = explode('_', $key)[1];
                        break;
                    }
                }
                echo '<div class="card card-body w-25 m-auto">';
            }
            ?>
            <?php if ($showAddUserForm) : ?>
                <h5>Ajouter un utilisateur</h5>
                <?php echo $addUserForm; ?>
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php elseif ($showAddUserForm === false) : ?>
                <h5>Modifier un utilisateur</h5>
                <?php echo $editUserForm; ?>
                <input type="hidden" name="userId" value="<?php echo $_POST['userId']; ?>">
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php endif; ?>

        </section>



        <!-- Tableau des services -->
        <section class="container my-5">
            <h3>Services</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Services</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicesData as $service) : ?>
                        <tr>
                            <td><?php echo $service->name; ?></td>
                            <td><?php echo $service->description; ?></td>
                            <td>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="serviceId" value="<?php echo $service->id; ?>">
                                    <button type="submit" class="btn btn-primary" name="editService">Modifier</button>
                                </form>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="serviceId" value="<?php echo $service->id; ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteService">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($servicesController) && !empty($servicesController->getErrorMessage())) : ?>
                <div class="alert alert-danger"><?php echo $servicesController->getErrorMessage(); ?></div>
            <?php endif; ?>


            <form action="" method="POST">
                <button type="submit" class="btn btn-primary" name="addServices">Ajouter</button>
            </form>


            <?php
            $showAddServiceForm = '';
            if (isset($_POST['addServices'])) {
                $showAddServiceForm = true;
                echo '<div class="card card-body w-25 m-auto">';
            } else if (isset($_POST['editService'])) {
                $showAddServiceForm = false;
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'editService_') !== false) {
                        $ServiceId = explode('_', $key)[1];
                        break;
                    }
                }
                echo '<div class="card card-body w-25 m-auto">';
            }
            ?>
            <?php if ($showAddServiceForm) : ?>
                <h5>Ajouter un services</h5>
                <?php echo $addServiceForm; ?>
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php elseif ($showAddServiceForm === false) : ?>
                <h5>Modifier un service</h5>
                <?php echo $editServiceForm; ?>
                <input type="hidden" name="serviceId" value="<?php echo $_POST['serviceId']; ?>">
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php endif; ?>
            </div>
        </section>



        <!-- Tableau des voitures -->
        <section class="container my-5">
            <h3>Voitures en stock</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Marque</th>
                        <th>Année</th>
                        <th>Prix</th>
                        <th>Kilométrage</th>
                        <th>Description</th>
                        <th>Caractéristiques</th>
                        <th>Equipement</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carsData as $car) : ?>
                        <tr>
                            <td><?php echo $car->name; ?></td>
                            <td><?php echo $car->brand; ?></td>
                            <td><?php echo $car->year; ?></td>
                            <td><?php echo $car->price; ?></td>
                            <td><?php echo $car->miles; ?></td>
                            <td><?php echo $car->description; ?></td>
                            <td><?php echo $car->caracteristics; ?></td>
                            <td><?php echo $car->equipement; ?></td>
                            <td>
                                <?php
                                $mediaPaths = $mediaModel->getMediaPathsByCarId($car->id);
                                foreach ($mediaPaths as $index => $media) :
                                    $imagePath = $media->path;
                                ?>
                                    <img src="../../../<?php echo $imagePath ?>" alt="Photo de voiture" width="100">
                                <?php endforeach ?>
                            </td>
                            <td>
                                <form action="" method="post" id="myForm" style="display: inline;">
                                    <input type="hidden" name="carId" value="<?php echo $car->id; ?>">
                                    <button type="submit" class="btn btn-primary" name="editCar">Modifier</button>
                                </form>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="carId" value="<?php echo $car->id; ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteCar">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (isset($carsController) && !empty($carsController->getErrorMessage())) : ?>
                <div class="alert alert-danger"><?php echo $carsController->getErrorMessage(); ?></div>
            <?php endif; ?>


            <form action="" method="POST">
                <button type="submit" class="btn btn-primary" name="addCars">Ajouter</button>
            </form>
            <?php
            $showAddCarForm = '';
            if (isset($_POST['addCars'])) {
                $showAddCarForm = true;
                echo '<div class="card card-body w-50 m-auto">';
            } else if (isset($_POST['editCar'])) {
                $showAddCarForm = false;
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'editCar_') !== false) {
                        $carId = explode('_', $key)[1];
                        break;
                    }
                }
                echo '<div class="card card-body w-50 m-auto">';
            }
            ?>
            <?php if ($showAddCarForm) : ?>
                <h5>Ajouter une voiture</h5>
                <?php echo $addCarForm; ?>
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php elseif ($showAddCarForm === false) : ?>
                <h5>Modifier une voiture</h5>
                <?php echo $editCarForm; ?>
                <input type="hidden" name="carId" value="<?php echo $_POST['carId']; ?>">
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php endif; ?>
            </div>
        </section>
    </main>



<?php endif ?>

<?php
require_once __DIR__ . '/../Templates/footer.php';
?>