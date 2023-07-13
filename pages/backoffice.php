<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require '../pages/templates/header.php';

use App\Database;

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

?>


    <main>
        <!-- Tableau des utilisateur !-->

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
                                <button class="btn btn-primary" onclick="modifierUtilisateur(<?php echo $user['id']; ?>)">Modifier</button>
                                <button class="btn btn-danger" onclick="supprimerUtilisateur(<?php echo $user['id']; ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <?php
            // Formulaire pour ajouter un utilisateur
            $userForm = new \App\FormCreator();
            $userForm->addField('username', 'text', 'Nom d\'utilisateur');
            $userForm->addField('password', 'password', 'Définir le mot de passe');
            $userForm->addField('role', 'text', 'Rôle (1 pour admin / 2 pour employé)');
            $addUserForm = $userForm->generateForm('Ajouter');
            ?>
            <div class="card card-body w-25 m-auto">
                <h5>Ajouter un utilisateur</h5>
                <?php echo $addUserForm ?>
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


                $serviceForm = new \App\FormCreator();
                $serviceForm->addField('name', 'text', 'Nom du service');
                $serviceForm->addField('description', 'textarea', 'Description');
                $addServiceForm = $serviceForm->generateForm('Ajouter');
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
            $carForm = new \App\FormCreator();
            $carForm->addField('name', 'text', 'Nom de la voiture');
            $carForm->addField('brand', 'text', 'Marque');
            $carForm->addField('year', 'text', 'Année de circulation');
            $carForm->addField('miles', 'text', 'Kilomètres');
            $carForm->addField('description', 'textarea', 'Description');
            $carForm->addField('caracteristics', 'textarea', 'Caractéristiques');
            $carForm->addField('equipments', 'textarea', 'Equipements');
            $carForm->addField('image', 'image', 'image', true);
            $addCarForm = $carForm->generateForm('Ajouter');
            ?>
            <div class="card card-body w-50 m-auto">
                <h2>Ajouter une voiture</h2>
                <?php echo $addCarForm; ?>
            </div>
        </section>
    </main>


<?php

} else {
    header('Location: ../pages/login.php');
    exit;
}

?>