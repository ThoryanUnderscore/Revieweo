<?php
class Critique {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Lire UNE critique avec ses catégories (Jointure SQL)
    public function findById($id) {
        $sql = "SELECT c.*, u.pseudo FROM Critique c 
                JOIN User u ON c.id_user = u.id 
                WHERE c.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $critique = $stmt->fetch();

        if ($critique) {
            // On récupère aussi les catégories liées 
            $sqlCat = "SELECT cat.nom FROM Categorie cat 
                       JOIN Critique_Categorie cc ON cat.id = cc.id_categorie 
                       WHERE cc.id_critique = ?";
            $stmtCat = $this->pdo->prepare($sqlCat);
            $stmtCat->execute([$id]);
            $critique['categories'] = $stmtCat->fetchAll();
        }
        return $critique;
    }

    // Publier et lier à une catégorie
    public function save($titre, $contenu, $note, $id_user, $id_categorie) {
        try {
            $this->pdo->beginTransaction(); // Sécurise l'écriture dans 2 tables

            // 1. Insertion dans Critique [cite: 65]
            $sql = "INSERT INTO Critique (titre, contenu, note, id_user, date_creation) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titre, $contenu, $note, $id_user]);
            $id_critique = $this->pdo->lastInsertId();

            // 2. Liaison dans Critique_Categorie 
            $sqlLiason = "INSERT INTO Critique_Categorie (id_critique, id_categorie) VALUES (?, ?)";
            $this->pdo->prepare($sqlLiason)->execute([$id_critique, $id_categorie]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // Pour le listing (Read) [cite: 47]
    public function findAll() {
        return $this->pdo->query("SELECT * FROM Critique ORDER BY date_creation DESC")->fetchAll();
    }
}