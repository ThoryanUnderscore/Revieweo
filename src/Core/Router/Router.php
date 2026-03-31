<?php

use Src\Controllers\AuthController;
use Src\Controllers\CritiqueController;

class Router {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function run() {
        // On récupère la page demandée, sinon 'home' par défaut
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch ($page) {
            case 'home':
                require_once 'app/Controllers/CritiqueController.php';
                $controller = new CritiqueController($this->db);
                $controller->index();
                break;

            case 'critique':
                // Pour afficher la critique n°1 : index.php?page=critique&id=1
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                require_once 'app/Controllers/CritiqueController.php';
                $controller = new CritiqueController($this->db);
                $controller->show($id);
                break;

            case 'login':
                require_once 'app/Controllers/AuthController.php';
                $controller = new AuthController($this->db);
                $controller->login();
                break;

            case 'logout':
                require_once 'app/Controllers/AuthController.php';
                $controller = new AuthController($this->db);
                $controller->logout();
                break;

            default:
                header("HTTP/1.0 404 Not Found");
                echo "Page non trouvée";
                break;
        }
    }
}