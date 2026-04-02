<?php

namespace Src\Core\Router;

use Src\Controllers\AuthController;
use Src\Controllers\CritiqueController;
use Src\Controllers\LikeController;
use Src\Controllers\AdminController;

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

            case 'admin':
                $controller = new AdminController($this->db);
                $controller->index();
                break;

            case 'admin-delete-user':
                $controller = new AdminController($this->db);
                $controller->deleteUser();
                break;

            case 'admin-delete-critique':
                $controller = new AdminController($this->db);
                $controller->deleteCritique();
                break;

            case 'admin-bulk-delete':
                $controller = new AdminController($this->db);
                $controller->bulkDeleteCritiques();
                break;

            case 'edit-critique':
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                $controller = new CritiqueController($this->db);
                $controller->edit($id);
                break;

            case 'delete-critique':
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                $controller = new CritiqueController($this->db);
                $controller->delete();
                break;
            
            case 'update-critique':
                $controller = new CritiqueController($this->db);
                $controller->update();
                break;

            default:
                header("HTTP/1.0 404 Not Found");
                echo "Page non trouvée";
                break;
        }
    }
}