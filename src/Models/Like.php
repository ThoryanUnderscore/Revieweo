<?php
class Like {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Ajouter ou retirer un like (Toggle)
    public function toggleLike($id_user, $id_critique) {
        $stmt = $this->pdo->prepare("SELECT * FROM `Like` WHERE id_user = ? AND id_critique = ?");
        $stmt->execute([$id_user, $id_critique]);
        
        if ($stmt->fetch()) {
            return $this->pdo->prepare("DELETE FROM `Like` WHERE id_user = ? AND id_critique = ?")
                             ->execute([$id_user, $id_critique]);
        } else {
            return $this->pdo->prepare("INSERT INTO `Like` (id_user, id_critique) VALUES (?, ?)")
                             ->execute([$id_user, $id_critique]);
        }
    }
}