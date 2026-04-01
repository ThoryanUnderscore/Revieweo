<?php
namespace Src\Models;

class Categorie {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $this->ensureDefaultCategories();

        $stmt = $this->db->query("SELECT * FROM categorie ORDER BY nom ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function ensureDefaultCategories() {
        $defaultCategories = ['Films', 'Séries', 'Jeux vidéos', 'Livres'];

        $countStmt = $this->db->query("SELECT COUNT(*) FROM Categorie");
        $count = (int) $countStmt->fetchColumn();

        if ($count === 0) {
            $insertStmt = $this->db->prepare("INSERT INTO Categorie (nom) VALUES (?)");

            foreach ($defaultCategories as $categorie) {
                $insertStmt->execute([$categorie]);
            }
        }
    }
}