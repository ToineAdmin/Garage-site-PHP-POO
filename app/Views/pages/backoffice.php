<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../Templates/header.php';


use App\Models\Database;
use App\Models\UserModel;
use App\Controllers\UsersController;

//Instance des objets
$db = new Database('db_garage');
$userModel = new UserModel($db);
$usersController = new UsersController($userModel);

//Récupère les données
$data = $usersController->index();
$usersData = $data['usersData'];
$addUserForm = $data['addUserForm'];
$editUserForm = $data['editUserForm'];


//Traitement de formulaire
$usersController->addUserSubmit();
$usersController->deleteUserSubmit();

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

            <div class="container">
                <button id="btn-add-user" class="btn btn-primary btn-add-user">Ajouter</button>
            </div>
            <div id="add-user-form" style="display: none;" class="w-25">
                <?php echo $addUserForm; ?>
            </div>
        </section>
    </main>
<?php endif ?>

<?php
require_once __DIR__ . '/../Templates/footer.php';
?>