<?php

// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'GestionDemandeModules';
$username = 'root';
$password = '';

try {
    // Création d'une instance de PDO avec les paramètres de connexion
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Configuration de l'attribut PDO::ATTR_ERRMODE à PDO::ERRMODE_EXCEPTION
    // pour que PDO lève des exceptions lorsqu'une erreur survient
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Utilisation de la connexion PDO
    // ...

} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
