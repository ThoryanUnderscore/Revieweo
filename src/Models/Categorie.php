<?php
namespace Src\Models;

class Categorie {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categorie ORDER BY nom ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}