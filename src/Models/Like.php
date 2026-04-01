<?php
namespace Src\Models;

class Like {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Ajouter ou retirer un like (Toggle)
    public function toggleLike($id_user, $id_critique) {
        $stmt = $this->pdo->prepare("SELECT * FROM Like_Critique WHERE id_user = ? AND id_critique = ?");
        $stmt->execute([$id_user, $id_critique]);

        if ($stmt->fetch()) {
            return $this->pdo->prepare("DELETE FROM Like_Critique WHERE id_user = ? AND id_critique = ?")
                             ->execute([$id_user, $id_critique]);
        } else {
            return $this->pdo->prepare("INSERT INTO Like_Critique (id_user, id_critique) VALUES (?, ?)")
                             ->execute([$id_user, $id_critique]);
        }
    }

    // Compter le nombre de likes pour une critique
    public function countLikes($id_critique) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Like_Critique WHERE id_critique = ?");
        $stmt->execute([$id_critique]);
        return (int) $stmt->fetchColumn();
    }

    // Vérifier si un utilisateur a liké une critique
    public function hasLiked($id_user, $id_critique) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Like_Critique WHERE id_user = ? AND id_critique = ?");
        $stmt->execute([$id_user, $id_critique]);
        return (int) $stmt->fetchColumn() > 0;
    }
}