<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'revieweo';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;

    /**
     * Connexion à la base de données avec PDO
     */
    public function connect() {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=' . $this->charset;
            
            $this->pdo = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            return $this->pdo;
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    /**
     * Obtenir l'instance PDO
     */
    public function getPDO() {
        if ($this->pdo === null) {
            $this->connect();
        }
        return $this->pdo;
    }
}
