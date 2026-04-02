<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Core\Database;
use Src\Core\Router\Router;

try {
        $db = Database::getConnection();
        $dbStatus = "<span class='badge bg-success'>Connecté à MariaDB</span>";
    } catch (\Exception $e) {
        $dbStatus = "<span class='badge bg-danger'>Erreur DB : " . $e->getMessage() . "</span>";
    }

    $router = new Router($db);
    $router->run();

?>