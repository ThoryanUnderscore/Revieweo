<?php
namespace Src\Core;
use PDO;
use PDOException;
class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                $host = 'localhost';
                $db   = 'revieweo';
                $user = 'root';
                $pass = '';
                
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8",
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}