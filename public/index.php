<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;



if (isset($_GET['p'])){
    $p = $_GET['p'];
} else {
    $p = 'home';
}

// Instance de la base de données pour l'utilisé dans la page
$db = new Database('db_garage');


if ($p === 'home'){
    require '../pages/home.php';
} else if ($p === 'occasion'){
    require '../pages/occasion.php';
};

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