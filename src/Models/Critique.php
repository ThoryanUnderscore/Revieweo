<?php
namespace Src\Models;

use Exception;
use PDO;

class Critique {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function findById($id) {
        $sql = "SELECT c.*, u.pseudo, cc.id_categorie, cat.nom AS nom_categorie 
            FROM critique c 
            JOIN user u ON c.id_user = u.id 
            LEFT JOIN critique_categorie cc ON c.id = cc.id_critique
            LEFT JOIN Categorie cat ON cc.id_categorie = cat.id
            WHERE c.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($search = null) {
        // Jointure pour le pseudo + Sous-requête pour compter les likes de chaque critique
        $sql = "SELECT c.*, u.pseudo, cat.nom AS nom_categorie,
            (SELECT COUNT(*) FROM like_critique l WHERE l.id_critique = c.id) as total_likes
            FROM critique c
            JOIN user u ON c.id_user = u.id
            LEFT JOIN critique_categorie cc ON c.id = cc.id_critique
            LEFT JOIN Categorie cat ON cc.id_categorie = cat.id";

        if ($search) {
            $sql .= " WHERE c.titre LIKE :search";
        }

        $sql .= " ORDER BY c.date_creation DESC";

        $stmt = $this->pdo->prepare($sql);
        
        if ($search) {
            $stmt->execute(['search' => '%' . $search . '%']);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM critique WHERE id = ?";
        return $this->pdo->prepare($sql)->execute([$id]);
    }

    // public function update($id, $titre, $contenu, $note) {
    //     $sql = "UPDATE critique SET titre = ?, contenu = ?, note = ? WHERE id = ?";
    //     $stmt = $this->pdo->prepare($sql);
    //     return $stmt->execute([$titre, $contenu, $note, $id]);
    // }
    public function update($id, $titre, $contenu, $note, $id_categorie) {
    try {
        $this->pdo->beginTransaction();

        // Mise à jour de la table principale
        $sql = "UPDATE critique SET titre = ?, contenu = ?, note = ? WHERE id = ?";
        $this->pdo->prepare($sql)->execute([$titre, $contenu, $note, $id]);

        // Mise à jour de la table de liaison : on remplace l'ancienne par la nouvelle
        $sqlDelete = "DELETE FROM critique_categorie WHERE id_critique = ?";
        $this->pdo->prepare($sqlDelete)->execute([$id]);

        $sqlLink = "INSERT INTO critique_categorie (id_critique, id_categorie) VALUES (?, ?)";
        $this->pdo->prepare($sqlLink)->execute([$id, $id_categorie]);

        $this->pdo->commit();
        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        return false;
    }
}

    public function save($titre, $contenu, $note, $id_user, $id_categorie) {
        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO critique (titre, contenu, note, id_user, date_creation) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titre, $contenu, $note, $id_user]);
            $id_critique = $this->pdo->lastInsertId();

            $sqlLiason = "INSERT INTO critique_categorie (id_critique, id_categorie) VALUES (?, ?)";
            $this->pdo->prepare($sqlLiason)->execute([$id_critique, $id_categorie]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}