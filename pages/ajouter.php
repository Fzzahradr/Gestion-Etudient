<?php
session_start();
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $apogee = $_POST['apogee'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    @$date_naissance = $_POST['date_naissance'];
    $statut = $_POST['statut'];
    @$filiere = $_POST['filiere'];

    // Se connecter à la base de données
    require 'connexion.php';

    // Préparer et exécuter la requête d'insertion
    $sql = 'INSERT INTO etudiant (apogee, nom, prenom, date_naissance, statut, filiere)
                VALUES (:apogee, :nom, :prenom, :date_naissance, :statut, :filiere)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'apogee' => $apogee,
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $date_naissance,
        'statut' => $statut,
        'filiere' => $filiere,
    ]);
    header('Location: gestion.php');
    // Afficher un message de succès

}
