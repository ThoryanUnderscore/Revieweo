<?php

namespace App\Helpers;

/**
 * Classe Helper - Fonctions utilitaires
 */
class Helper {
    
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function hasRole($role) {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] >= $role;
    }

    public static function isAdmin() {
        return self::hasRole(2);
    }

    public static function isCritique() {
        return self::hasRole(1);
    }

    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public static function redirect($url, $statusCode = 302) {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }

    public static function h($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    public static function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePseudo($pseudo) {
        return preg_match('/^[a-zA-Z0-9_-]{3,50}$/', $pseudo);
    }

    public static function validateNote($note) {
        return is_numeric($note) && $note >= 0 && $note <= 10;
    }

    public static function requirePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Méthode non autorisée');
        }
    }

    public static function logout() {
        $_SESSION = [];
        session_destroy();
        self::redirect('/');
    }

    public static function formatDate($date, $format = 'd/m/Y H:i') {
        return date($format, strtotime($date));
    }

    public static function timeAgo($datetime) {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) {
            return 'à l\'instant';
        } elseif ($diff < 3600) {
            $min = floor($diff / 60);
            return 'il y a ' . $min . ' minute' . ($min > 1 ? 's' : '');
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return 'il y a ' . $hours . ' heure' . ($hours > 1 ? 's' : '');
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return 'il y a ' . $days . ' jour' . ($days > 1 ? 's' : '');
        } else {
            return self::formatDate($datetime, 'd/m/Y');
        }
    }

    public static function truncate($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }

    public static function slug($text) {
        // Convertir en minuscules
        $text = strtolower($text);
        // Remplacer les caractères spéciaux
        $text = preg_replace('/[^a-z0-9-]+/', '-', $text);
        // Supprimer les tirets en début/fin
        $text = trim($text, '-');
        return $text;
    }
}
