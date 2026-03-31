<?php

namespace App\Models;

class Categorie extends BaseModel {
    protected $table = 'Categorie';

    public function findByNom($nom) {
        return $this->findWhere(['nom' => $nom]);
    }

    public function createCategory($nom) {
        return $this->create(['nom' => $nom]);
    }
}
