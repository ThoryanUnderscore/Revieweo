<?php
namespace Src\Controllers;

use Src\Models\Critique;
use Src\Models\Categorie;

class CritiqueController {
    private $critiqueModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->critiqueModel = new Critique($db);
    }

    public function show($id) {
        $critique = $this->critiqueModel->findById($id);
        if (!$critique) { header("Location: index.php?page=home"); exit; }
        
        $title = $critique['titre'];
        ob_start();
        require_once __DIR__ . '/../../template/critique/detail.php';
        $content = ob_get_clean();
        
        require_once __DIR__ . '/../../template/layout/layout.php';
    }

    public function home() {
        $search = $_GET['search'] ?? null;
        $critiques = $this->critiqueModel->findAll($search);

        if (isset($_GET['ajax'])) {
            require_once __DIR__ . '/../../template/home/listing.php';
            exit;
        }

        $title = "Accueil";
        ob_start();
        require_once __DIR__ . '/../../template/home/listing.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }

    public function add() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
            header("Location: index.php?page=login"); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->critiqueModel->save(
                $_POST['titre'], 
                $_POST['contenu'], 
                $_POST['note'], 
                $_SESSION['user_id'], 
                $_POST['id_categorie']
            );
            header("Location: index.php?page=home"); exit;
        }

        $catModel = new Categorie($this->db);
        $catModel->ensureDefaultCategories();
        $categories = $catModel->getAll();
        $title = "Rédiger une critique";
        
        ob_start();
        require_once __DIR__ . '/../../template/critique/form.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }
}