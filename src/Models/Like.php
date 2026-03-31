<?php

namespace App\Models;

class Like extends BaseModel {
    protected $table = 'Like_Critique';

    public function addLike($userId, $critiqueId) {
        $query = 'INSERT INTO Like_Critique (id_user, id_critique) 
                  VALUES (:userId, :critiqueId)';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':userId' => $userId,
            ':critiqueId' => $critiqueId
        ]);
    }

    public function removeLike($userId, $critiqueId) {
        $query = 'DELETE FROM Like_Critique 
                  WHERE id_user = :userId AND id_critique = :critiqueId';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':userId' => $userId,
            ':critiqueId' => $critiqueId
        ]);
    }

    public function userLikedCritique($userId, $critiqueId) {
        $query = 'SELECT COUNT(*) as total FROM Like_Critique 
                  WHERE id_user = :userId AND id_critique = :critiqueId';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':userId' => $userId,
            ':critiqueId' => $critiqueId
        ]);
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->total > 0;
    }

    public function countLikesByCritique($critiqueId) {
        $query = 'SELECT COUNT(*) as total FROM Like_Critique WHERE id_critique = :critiqueId';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':critiqueId' => $critiqueId]);
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->total;
    }
}
