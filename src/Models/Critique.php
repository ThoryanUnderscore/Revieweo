<?php

namespace App\Models;

class Critique extends BaseModel {
    protected $table = 'Critique';

    public function createCritique($titre, $contenu, $note, $userId) {
        if ($note < 0 || $note > 10) {
            throw new \InvalidArgumentException('La note doit être entre 0 et 10');
        }

        return $this->create([
            'titre' => $titre,
            'contenu' => $contenu,
            'note' => $note,
            'id_user' => $userId,
            'is_pinned' => false,
            'is_deleted' => false
        ]);
    }

    public function getPublished() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE is_deleted = 0 ORDER BY date_creation DESC';
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
