<?php

// Heure UTC
date_default_timezone_set('Europe/Paris');

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure l'autoloader
require_once __DIR__ . '/autoload.php';

// Initialiser la connexion à la base de données
$database = new Database();
$pdo = $database->connect();

// Créer une fonction helper pour accéder simplement à la BDD
if (!function_exists('getPDO')) {
    function getPDO() {
        global $pdo;
        return $pdo;
    }
}

// Constantes utiles
define('APP_ROOT', __DIR__);
define('APP_URL', 'http://localhost/projet-web');
define('APP_ENV', 'development'); // development ou production

// Gestion des erreurs
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 0);
}
