<?php

namespace App\Models;

class User extends BaseModel {
    protected $table = 'User';

    public function findByEmail($email) {
        return $this->findWhere(['email' => $email]);
    }

    public function findByPseudo($pseudo) {
        return $this->findWhere(['pseudo' => $pseudo]);
    }

    public function register($pseudo, $email, $password, $role = 0) {
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->create([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }

    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function getAllCritiques() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE role = 1';
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function isAdmin($id) {
        $user = $this->find($id);
        return $user && $user->role === 2;
    }

    public function isCritique($id) {
        $user = $this->find($id);
        return $user && ($user->role === 1 || $user->role === 2);
    }

    public function promoteToCritique($id) {
        return $this->update($id, ['role' => 1]);
    }

    public function promoteToAdmin($id) {
        return $this->update($id, ['role' => 2]);
    }

    public function demoteToUser($id) {
        return $this->update($id, ['role' => 0]);
    }
}
