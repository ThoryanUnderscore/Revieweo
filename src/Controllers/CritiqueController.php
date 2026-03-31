<?php

namespace Src\Controllers;
use Critique;

class CritiqueController {
    private $model;

    public function __construct($db) {
        $this->model = new Critique($db);
    }

    // Affiche la liste (Page d'accueil/Listing) [cite: 47]
    public function index() {
        $critiques = $this->model->findAll();
        require_once 'views/home/listing.php';
    }

    // Affiche UNE seule critique (ex: /critique/1) [cite: 48]
    public function show($id) {
        $critique = $this->model->findById($id);
        if (!$critique) {
            die("Critique introuvable.");
        }
        require_once 'views/critique/detail.php';
    }

    // Formulaire de création (réservé aux Critiques/Admin) [cite: 53, 56]
    public function create() {
        if ($_SESSION['role'] < 2) { // 2 = Critique [cite: 32]
            header('Location: index.php?error=access_denied');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->save(
                $_POST['titre'], 
                $_POST['contenu'], 
                $_POST['note'], 
                $_SESSION['user_id'],
                $_POST['id_categorie']
            );
            if ($success) header('Location: index.php?success=1');
        }
        require_once 'views/critique/form.php';
    }
}