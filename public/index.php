<?php

namespace Public\Index;
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\Database;




$p = isset($_GET['p']) ? $_GET['p'] : 'home';

// Instance de la base de données pour l'utiliser dans la page
$db = new Database('db_garage');

if ($p === 'home') {
    require '../app/Views/pages/home.php';

    // Gérer les autres cas ou les valeurs de p spécifiques
    // par exemple, vous pouvez afficher une page d'erreur ou une redirection par défaut.
}


// $db = new Database('db_garage');
// $data = $db->query('INSERT INTO users(username) VALUES (users'); 


// foreach ($data as $row) {
//     echo $row->username. "<br>";
// }
// $data = donnée que l'ont souhaite récupérer

?>

<!-- 

    >>> Mettre $data = $db->query('SELECT * FROM users'); dans les class Services, Cars, Users pour récupérer et l'injecter dans le HTML

 -->