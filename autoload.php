<?php

spl_autoload_register(function ($class) {
    // Namespace à remplacer
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';

    // Vérifier si la classe utilise le prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Obtenir le chemin du fichier
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // Si le fichier existe, le charger
    if (file_exists($file)) {
        require $file;
    }
});

// Charger la configuration de la base de données
require_once __DIR__ . '/config/Database.php';
