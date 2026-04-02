<?php
namespace Src\Controllers;

use Src\Models\User;
use Src\Models\Critique;

class AdminController {
    private $userModel;
    private $critiqueModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?page=login');
            exit('Accès refusé.');
        }

        $this->userModel = new User($db);
        $this->critiqueModel = new Critique($db);
    }

    public function index() {
        $users = $this->userModel->getAll();
        $critiques = $this->critiqueModel->findAll();

        $title = "Panel Administration";
        
        ob_start();
        require_once __DIR__ . '/../../template/user/admin.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }

    public function deleteUser() {
        if (isset($_GET['id'])) {
            $this->userModel->delete((int)$_GET['id']);
        }
        header('Location: index.php?page=admin');
        exit;
    }

    public function deleteCritique() {
        if (isset($_GET['id'])) {
            $this->critiqueModel->delete((int)$_GET['id']);
        }
        header('Location: index.php?page=admin');
        exit;
    }

    public function bulkDeleteCritiques() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $id) {
                $this->critiqueModel->delete((int)$id);
            }
        }
        header('Location: index.php?page=admin');
        exit;
    }
}