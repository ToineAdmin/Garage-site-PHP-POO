<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';

use App\Models\Users;
use App\Models\Database;
use App\Models\FormCreator;


$db = new Database('db_garage');

// Vérification de la connexion de l'utilisateur et du rôle "admin"
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'admin') {
    // Récupération des données de la table "users"
    $usersStmt = $db->getPDO()->prepare("SELECT * FROM users");
    $usersStmt->execute();
    $usersData = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des données de la table "services"
    $servicesStmt = $db->getPDO()->prepare("SELECT * FROM services");
    $servicesStmt->execute();
    $servicesData = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des données de la table "cars"
    $carsStmt = $db->getPDO()->prepare("SELECT * FROM cars");
    $carsStmt->execute();
    $carsData = $carsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Formulaire pour ajouter un utilisateur
    $userForm = new FormCreator();
    $userForm->addField('username', 'text', 'Nom d\'utilisateur');
    $userForm->addField('password', 'password', 'Définir le mot de passe');
    $userForm->addField('role', 'text', 'Rôle (1 pour admin / 2 pour employé)');
    $addUserForm = $userForm->generateForm('addUser', 'Ajouter',true);

    // FORMULAIRE MODIFIER SI AJOUT MODIFIER CLIC
    $editUserForm = '';
    $userId = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editUser'])) {
        if (isset($_POST['userId'])) {
            var_dump($_POST);
            $userId = $_POST['userId'];

            // Récupérer les données de l'utilisateur à modifier
            $userStmt = $db->getPDO()->prepare("SELECT * FROM users WHERE id = :id");
            $userStmt->bindParam(':id', $userId);
            $userStmt->execute();
            $userData = $userStmt->fetch(PDO::FETCH_ASSOC);

            // Générer le formulaire de modification pré-rempli avec les données actuelles de l'utilisateur
            $userForm->setValues($userData);

            $editUserForm = $userForm->generateForm('updateUser', 'Modifier', false);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['addUser'])) {
            $username = $userForm->clearInput($_POST['username']);
            $password = $userForm->clearInput($_POST['password']);
            $role = $userForm->clearInput($_POST['role']);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Appel de la méthode addUser de la classe Users pour ajouter l'utilisateur à la base de données
            $user = new Users($db);
            $user->addUser($username, $hashedPassword, $role);

            // Redirection vers la page actuelle pour actualiser les données après l'ajout de l'utilisateur
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } elseif (isset($_POST['updateUser'])) {
            $userId = $_POST['userId'];
            $username = $userForm->clearInput($_POST['username']);
            $password = $userForm->clearInput($_POST['password']);
            $role = $userForm->clearInput($_POST['role']);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Appel de la méthode updateUser de la classe Users pour mettre à jour l'utilisateur dans la base de données
            $user = new Users($db);
            $user->updateUser($userId, $username, $hashedPassword, $role);

            // Redirection vers la page actuelle pour actualiser les données après la modification de l'utilisateur
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }



    // SUPPRESSION BDD
    // Formulaire suppresion soumis ?
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUser'])) {
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];

            // Supprime l'utilisateur de la base de données en utilisant l'ID récupéré
            $user = new Users($db);
            $user->deleteUser($userId);

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
?>

    <main>
        <!-- Tableau des utilisateurs -->
        <section class="container my-5">
            <h2>Utilisateurs</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Mot de passe</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersData as $user) : ?>
                        <tr>
                            <?php foreach ($user as $key => $value) :
                                if ($key !== 'id') : ?>
                                    <td><?php echo $value; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <td>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-primary" name="editUser">Modifier</button>
                                </form>
                                <form action="" method="post" style="display: inline;">
                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="deleteUser">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="card card-body w-25 m-auto">
                <?php if (empty($editUserForm)) : ?>
                    <h5>Ajouter un utilisateur</h5>
                    <form action="" method="post">
                        <?php echo $addUserForm; ?>
                    </form>
                <?php else : ?>
                    <h5>Modifier un utilisateur</h5>
                        <form method="POST" action="">
                        <?php
                        echo $userForm->generateForm('updateUser', 'Modifier', false);
                        ?>
                        <input type="hidden" name="userId" value="<?php echo $userData['id']; ?>">
                        </form>

                <?php endif; ?>
            </div>

        </section>
        <!-- Tableau des services -->


        <section class="container my-5">
            <h2>Services</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($servicesData as $service) : ?>
                        <tr>
                            <?php foreach ($service as $key => $value) :
                                if ($key !== 'id') : ?>
                                    <td><?php echo $value; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <td>
                                <button class="btn btn-primary" onclick="modifierService(<?php echo $service['id']; ?>)">Modifier</button>
                                <button class="btn btn-danger" onclick="supprimerService(<?php echo $service['id']; ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <div class="container">
                <?php

                // Formulaire pour ajouter un service


                $serviceForm = new FormCreator();
                $serviceForm->addField('name', 'text', 'Nom du service');
                $serviceForm->addField('description', 'textarea', 'Description');
                $addServiceForm = $serviceForm->generateForm('addService', 'Ajouter',true);
                ?>

                <div class="card card-body w-25 m-auto">
                    <h5>Ajouter un service</h5>
                    <?php echo $addServiceForm; ?>
                </div>
            </div>
        </section>



        <!-- Tableau des voitures -->


        <section class="container my-5">
            <h2>Voitures</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Marque</th>
                        <th>Année de circulation</th>
                        <th>Prix</th>
                        <th>Kilomètres</th>
                        <th>Description</th>
                        <th>Caractéristiques</th>
                        <th>Equipements</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carsData as $car) : ?>
                        <tr>
                            <?php foreach ($car as $key => $value) :
                                if ($key !== 'id' && $key !== 'user_id') : ?>
                                    <td><?php echo $value; ?></td>
                                <?php endif ?>
                            <?php endforeach ?>
                            <td>
                                <button class="btn btn-primary" onclick="modifierVoiture(<?php echo $car['id']; ?>)">Modifier</button>
                                <button class="btn btn-danger" onclick="supprimerVoiture(<?php echo $car['id']; ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php
            // Formulaire pour ajouter une voiture
            $carForm = new FormCreator();
            $carForm->addField('name', 'text', 'Nom de la voiture');
            $carForm->addField('brand', 'text', 'Marque');
            $carForm->addField('year', 'text', 'Année de circulation');
            $carForm->addField('miles', 'text', 'Kilomètres');
            $carForm->addField('description', 'textarea', 'Description');
            $carForm->addField('caracteristics', 'textarea', 'Caractéristiques');
            $carForm->addField('equipments', 'textarea', 'Equipements');
            $carForm->addField('image', 'image', 'image', true);
            $addCarForm = $carForm->generateForm('addCar', 'Ajouter',true);
            ?>
            <div class="card card-body w-50 m-auto">
                <h2>Ajouter une voiture</h2>
                <?php echo $addCarForm; ?>
            </div>
        </section>
    </main>


<?php



} else { // rajouter elseif role= employe qu'est ce qu'on affiche 
    header('Location: ../pages/login.php');
    exit;
}

?>