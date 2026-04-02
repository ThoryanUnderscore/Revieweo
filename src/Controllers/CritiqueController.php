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
        $categories = $catModel->getAll();
        $title = "Rédiger une critique";
        
        ob_start();
        require_once __DIR__ . '/../../template/critique/form.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }

    public function edit($id) {
    $critique = $this->critiqueModel->findById($id);

    if (!$critique || ($_SESSION['user_id'] != $critique['id_user'] && $_SESSION['role'] != 2)) {
        header('Location: index.php?page=home');
        exit;
    }

    $catModel = new \Src\Models\Categorie($this->db);
    $categories = $catModel->getAll(); 

    $title = "Modifier : " . $critique['titre'];
    
    ob_start();
    // Maintenant, $categories sera disponible dans edit_form.php
    require_once __DIR__ . '/../../template/critique/edit_form.php';
    $content = ob_get_clean();
    
    require_once __DIR__ . '/../../template/layout/layout.php';
}

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $titre = $_POST['titre'];
            $note = $_POST['note'];
            $contenu = $_POST['contenu'];
            $categorie = $_POST['id_categorie'];

            $critique = $this->critiqueModel->findById($id);
            if ($critique && ($_SESSION['user_id'] == $critique['id_user'] || $_SESSION['role'] == 2)) {
                $this->critiqueModel->update($id, $titre, $contenu, $note, $categorie);
            }
        }
        
        header('Location: index.php?page=home');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        $critique = $this->critiqueModel->findById($id);

        if ($critique) {
            if ($_SESSION['user_id'] == $critique['id_user'] || $_SESSION['role'] == 2) {
                $this->critiqueModel->delete($id);
            }
        }
        
        header('Location: index.php?page=home');
        exit;
    }
}