<?php
namespace Src\Models;

class Like {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function countByCritique($id_critique) {
        $sql = "SELECT COUNT(*) FROM like_critique WHERE id_critique = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_critique]);
        return $stmt->fetchColumn();
    }

    public function isLikedByUser($id_user, $id_critique) {
        $sql = "SELECT COUNT(*) FROM like_critique WHERE id_user = ? AND id_critique = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_user, $id_critique]);
        return $stmt->fetchColumn() > 0;
    }

    public function toggle($id_user, $id_critique) {
        if ($this->isLikedByUser($id_user, $id_critique)) {
            $sql = "DELETE FROM like_critique WHERE id_user = ? AND id_critique = ?";
        } else {
            $sql = "INSERT INTO like_critique (id_user, id_critique) VALUES (?, ?)";
        }
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_user, $id_critique]);
    }
}