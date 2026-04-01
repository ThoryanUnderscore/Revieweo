<?php

namespace Src\Core\Router;

use Src\Controllers\AuthController;
use Src\Controllers\CritiqueController;
use Src\Controllers\LikeController;

class Router {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function run() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch ($page) {
            case 'home':
                $controller = new CritiqueController($this->db);
                $controller->home();
                break;

            case 'login':
                $controller = new AuthController($this->db);
                $controller->login();
                break;

            case 'register':                
                $controller = new AuthController($this->db);
                $controller->register();
                break;

            case 'logout':
                $controller = new AuthController($this->db);
                $controller->logout();
                break;

            case 'add-critique':
                $controller = new CritiqueController($this->db);
                $controller->add();
                break;

            case 'detail':
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                $controller = new CritiqueController($this->db);
                $controller->show($id);
                break;

            case 'like':
                $controller = new LikeController($this->db);
                $controller->toggle();
                break;

            default:
                header("HTTP/1.0 404 Not Found");
                echo "Page non trouvée";
                break;
        }
    }
}