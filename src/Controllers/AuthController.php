<?php
namespace Src\Controllers;
use User;

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['role'] = $user['role']; // 1: User, 2: Critique, 3: Admin [cite: 32, 41]
                header('Location: index.php?page=dashboard');
            } else {
                $error = "Identifiants incorrects";
            }
        }
        require_once 'views/user/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }
}