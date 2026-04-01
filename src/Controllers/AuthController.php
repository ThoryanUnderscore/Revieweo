<?php
namespace Src\Controllers;

use Src\Models\User;

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php?page=home"); exit;
            }
            $error = "Identifiants incorrects.";
        }

        $title = "Connexion";
        ob_start();
        require_once __DIR__ . '/../../template/user/login.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo   = $_POST['pseudo'];
            $email    = $_POST['email'];
            $password = $_POST['password'];
            
            // Sécurité : on s'assure que c'est soit 0 soit 1
            $role = (isset($_POST['role']) && $_POST['role'] == '1') ? 1 : 0;

            $success = $this->userModel->register($pseudo, $email, $password, $role);
            
        if ($success) {
            // Redirection vers la connexion avec un petit message de succès
            header("Location: index.php?page=login&status=registered");
            exit;
        } else {
            $error = "L'inscription a échoué (Email déjà utilisé ?)";
        }
        }

        $title = "Inscription";
        ob_start();
        require_once __DIR__ . '/../../template/user/register.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../../template/layout/layout.php';
    }
}