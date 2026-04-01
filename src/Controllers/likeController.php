<?php
namespace Src\Controllers;
use Src\Models\Like;
class LikeController {
    private $likeModel;

    public function __construct($db) {
        $this->likeModel = new Like($db);
    }

    // Cette méthode est appelée via une requête AJAX
    public function toggle() {
        // 1. Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Connexion requise']);
            return;
        }

        // 2. Récupérer l'ID de la critique envoyé en POST (ou via l'URL)
        $id_critique = isset($_POST['id_critique']) ? (int)$_POST['id_critique'] : 0;
        $id_user = $_SESSION['user_id'];

        if ($id_critique > 0) {
            // 3. Appeler le modèle pour ajouter/supprimer le like
            $result = $this->likeModel->toggleLike($id_user, $id_critique);

            if ($result) {
                // Récupérer le nouveau nombre de likes
                $likesCount = $this->likeModel->countLikes($id_critique);
                $hasLiked = $this->likeModel->hasLiked($id_user, $id_critique);

                echo json_encode([
                    'status' => 'success',
                    'likes_count' => $likesCount,
                    'user_liked' => $hasLiked
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erreur SQL']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID critique invalide']);
        }
    }
}