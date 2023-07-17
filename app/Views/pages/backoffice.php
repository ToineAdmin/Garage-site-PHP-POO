<?php
session_start();


require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';

use App\Controllers\MediasController;
use App\Models\Database;
use App\Models\UserModel;
use App\Models\ServiceModel;
use App\Controllers\UsersController;
use App\Controllers\ServicesController;
use App\Models\MediaModel;

//Instance des objets
$db = new Database('db_garage');
$mediaModel = new MediaModel($db);
$userModel = new UserModel($db);
$mediasController = new MediasController($mediaModel);
$usersController = new UsersController($userModel, $mediaModel, $mediasController);

$serviceModel = new serviceModel($db);
$servicesController = new servicesController($serviceModel);

//Récupère les données users
$data = $usersController->index();
$usersData = $data['usersData'];
$addUserForm = $data['addUserForm'];
$editUserForm = $data['editUserForm'];


//Récupère les données services
$data = $servicesController->Serviceindex();
$servicesData = $data['servicesData'];
$addServiceForm = $data['addServiceForm'];
$editServiceForm = $data['editServiceForm'];


//Traitement de formulaire users
$usersController->addUserSubmit();
$usersController->deleteUserSubmit();
$usersController->updateUserSubmit();

//Traitement de formulaire users
$servicesController->addServiceSubmit();
$servicesController->deleteServiceSubmit();
$servicesController->updateServiceSubmit();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



//affichage des formulaire modif et add



?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'admin') : ?>

    <main>
        <h2 class="my-5 text-center">Bienvenue dans votre espace d'administation <?= $_SESSION['username'] ?></h2>
        <section class="container my-5">
            <h3>Utilisateurs</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Mot de passe</th>
                        <th>Rôle</th>
                        <th>Métier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersData as $user) : ?>
                        <tr>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->password; ?></td>
                            <td><?php echo $user->role; ?></td>
                            <td><?php echo $user->job; ?></td>
                            <td>
                                <?php if (!empty($user->image_path)) : ?>
                                    <img src="<?php echo $user->image_path; ?>" alt="Photo de profil" width="50"><?php var_dump($user->image_path) ?>
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
                echo '<div class="card card-body w-25 m-auto">';
            } else if (isset($_POST['editUser'])) {
                $showAddUserForm = false;
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
                <input type="hidden" name="userId" value="<?php echo $user->id; ?>">
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php endif; ?>
            </div>
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
                <input type="hidden" name="serviceId" value="<?php echo $service->id; ?>">
                <button type="button" class="btn btn-danger" onclick="window.location.href = 'backoffice.php';">Annuler</button>
            <?php endif; ?>
            </div>
        </section>


    </main>
<?php endif ?>

<?php
require_once __DIR__ . '/../Templates/footer.php';
?>