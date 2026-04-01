<?php
namespace Src\Models;
use Exception;
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

            // On récupère le nombre de likes
            $sqlLikes = "SELECT COUNT(*) as likes_count FROM Like_Critique WHERE id_critique = ?";
            $stmtLikes = $this->pdo->prepare($sqlLikes);
            $stmtLikes->execute([$id]);
            $critique['likes_count'] = (int) $stmtLikes->fetchColumn();

            // Vérifier si l'utilisateur connecté a liké cette critique
            if (isset($_SESSION['user_id'])) {
                $sqlUserLike = "SELECT COUNT(*) FROM Like_Critique WHERE id_critique = ? AND id_user = ?";
                $stmtUserLike = $this->pdo->prepare($sqlUserLike);
                $stmtUserLike->execute([$id, $_SESSION['user_id']]);
                $critique['user_liked'] = (int) $stmtUserLike->fetchColumn() > 0;
            } else {
                $critique['user_liked'] = false;
            }
        }
        return $critique;
    }

    // Publier et lier à une catégorie
    public function save($titre, $contenu, $note, $id_user, $id_categorie) {
        try {
            $this->pdo->beginTransaction();

            // 1. Insertion dans Critique
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
    public function findAll($search = null) {
        // Requête pure : Uniquement la critique et l'auteur
        $sql = "SELECT critique.*, user.pseudo
                FROM critique
                JOIN user ON critique.id_user = user.id";

        if ($search) {
            $sql .= " WHERE critique.titre LIKE :search";
        }

        $sql .= " ORDER BY critique.date_creation DESC";

        $stmt = $this->pdo->prepare($sql);

        if ($search) {
            $stmt->execute(['search' => '%' . $search . '%']);
        } else {
            $stmt->execute();
        }

        $critiques = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Ajouter les informations de likes pour chaque critique
        foreach ($critiques as &$critique) {
            // Nombre de likes
            $sqlLikes = "SELECT COUNT(*) as likes_count FROM Like_Critique WHERE id_critique = ?";
            $stmtLikes = $this->pdo->prepare($sqlLikes);
            $stmtLikes->execute([$critique['id']]);
            $critique['likes_count'] = (int) $stmtLikes->fetchColumn();

            // Vérifier si l'utilisateur connecté a liké cette critique
            if (isset($_SESSION['user_id'])) {
                $sqlUserLike = "SELECT COUNT(*) FROM Like_Critique WHERE id_critique = ? AND id_user = ?";
                $stmtUserLike = $this->pdo->prepare($sqlUserLike);
                $stmtUserLike->execute([$critique['id'], $_SESSION['user_id']]);
                $critique['user_liked'] = (int) $stmtUserLike->fetchColumn() > 0;
            } else {
                $critique['user_liked'] = false;
            }
        }

        return $critiques;
    }
}