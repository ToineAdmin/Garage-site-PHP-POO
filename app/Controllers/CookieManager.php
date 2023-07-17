<?php
namespace App\Controllers;

class CookieManager {
    public static function setLoggedInCookie($username) {
        setcookie('loggedin', 'true', time() + 7200, '/'); // Crée un cookie "loggedin" valide pendant 1 heure
        setcookie('username', $username, time() + 7200, '/'); // Crée un cookie "username" valide pendant 1 heure
        // Ajoutez d'autres cookies si nécessaire
    }

    public static function deleteLoggedInCookie() {
        setcookie('loggedin', '', time() - 3600, '/');
        setcookie('username', '', time() - 3600, '/');
        // Supprimez d'autres cookies si nécessaire
    }

    public static function isLoggedIn() {
        return isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === 'true';
    }
}
?>
