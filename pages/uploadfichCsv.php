<?php
session_start();
// Vérification du formulaire soumis
if (isset($_POST['submit'])) {

    // Connexion à la base de données
    require 'connexion.php';

    if (!isset($_FILES['file'])) {
        echo "Aucun fichier n'a été sélectionné.";
        die();
    }

    $file = $_FILES['file'];
    $file_type = $file['type'];

    if ($file_type !== 'text/csv' && $file_type !== 'application/vnd.ms-excel') {
        echo "Le fichier doit être de type CSV.";
        die();
    }

    $required_fields = array('apogee', 'nom', 'prenom', 'date_naissance', 'statut', 'filiere');
    $csv_path = $file['tmp_name'];

    $sql = "LOAD DATA INFILE :csv_path 
            INTO TABLE etudiant 
            FIELDS TERMINATED BY ';' 
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES 
            (apogee, nom, prenom, @date_naissance, statut, filiere)
            SET date_naissance = STR_TO_DATE(@date_naissance_str, '%Y/%m/%d')";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':csv_path', $csv_path);
    
    if ($stmt->execute()) {
        // Redirection vers la page "gestion.php"
        header('Location: gestion.php');
        exit();
    } else {
        // Affichage du message d'erreur détaillé
        $error_info = $stmt->errorInfo();
        echo "Erreur lors de l'importation des données : " . $error_info[2];
        die();
    }
}
