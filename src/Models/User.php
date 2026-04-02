<?php
namespace Src\Models;

class User {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Inscription (Create)
    public function register($pseudo, $email, $password, $role = 0) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO User (pseudo, email, password, role) VALUES (?, ?, ?, ?)";
        return $this->pdo->prepare($sql)->execute([$pseudo, $email, $hash, $role]);
    }

    // Connexion (Read)
    public function login($email, $password) {
        $sql = "SELECT * FROM User WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function update($id, $pseudo, $email, $role) {
        $sql = "UPDATE User SET pseudo = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$pseudo, $email, $role, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM User WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

        public function getAll() {
        $sql = "SELECT id, pseudo, email, role FROM User ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM User WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}