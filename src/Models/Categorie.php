<?php
class Categorie {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM Categorie")->fetchAll();
    }
}