<?php
namespace Src\Controllers;

use Src\Models\Like;

class LikeController {
    private $db;
    private $likeModel;

    public function __construct($db) {
        $this->db = $db;
        $this->likeModel = new Like($db);
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function toggle() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
            exit;
        }

        // On accepte POST ou GET pour être flexible
        $id_critique = $_POST['id_critique'] ?? $_GET['id'] ?? 0;
        $id_user = $_SESSION['user_id'];

        $likeModel = new Like($this->db);
        $likeModel->toggle($id_user, $id_critique);
        
        // On récupère le nouveau compte
        $count = $likeModel->countByCritique($id_critique);
        $isLiked = $likeModel->isLikedByUser($id_user, $id_critique);

        // Réponse JSON pour le JS
        echo json_encode([
            'status' => 'success',
            'new_count' => $count,
            'is_liked' => $isLiked
        ]);
        exit;
    }
}