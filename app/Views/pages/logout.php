<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\CookieManager;
session_start();


$_SESSION = array();


session_destroy();

CookieManager::deleteLoggedInCookie();

header('Location: ../pages/login.php');
exit();
?>
