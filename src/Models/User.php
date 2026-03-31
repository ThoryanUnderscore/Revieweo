<?php
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
}