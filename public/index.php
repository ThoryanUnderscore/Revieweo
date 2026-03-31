<?php

use Src\Controllers\Critique;
use Database;

require_once 'src/Core/Database.php';
require_once 'src/Models/Critique.php';

$db = Database::getConnection();
$critiqueModel = new Critique($db);

// Exemple : Charger la critique n°1
$maCritique = $critiqueModel->findById(1);