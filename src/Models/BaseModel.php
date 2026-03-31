<?php

namespace App\Models;

use PDO;

abstract class BaseModel {
    protected $pdo;
    protected $table;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function find($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findWhere($conditions) {
        $where = [];
        $params = [];
        foreach ($conditions as $key => $value) {
            $where[] = $key . ' = :' . $key;
            $params[':' . $key] = $value;
        }
        
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . implode(' AND ', $where);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data) {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);
        
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $columns) . ') 
                  VALUES (' . implode(', ', $placeholders) . ')';
        
        $params = [];
        foreach ($columns as $col) {
            $params[':' . $col] = $data[$col];
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return (int)$this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $updates = [];
        $params = [];
        foreach ($data as $key => $value) {
            $updates[] = $key . ' = :' . $key;
            $params[':' . $key] = $value;
        }
        $params[':id'] = $id;

        $query = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
