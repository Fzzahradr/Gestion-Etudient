<?php
session_start();
// Vérification de la soumission du formulaire de modification
if (isset($_POST['submit'])) {
    echo 'tree';
    // Récupération des données du formulaire
    $idetud = $_POST['idetud'];
    $apogee = $_POST['apogee'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $statut = $_POST['statut'];
    $filiere = $_POST['filiere'];

    // Connexion à la base de données avec PDO
    $dsn = "mysql:host=localhost;dbname=GestionDemandeModules;charset=utf8mb4";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        echo 'tree';
    } catch (\PDOException $e) {
        echo 'faou';
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Requête de mise à jour de l'étudiant dans la base de données
    $sql = "UPDATE etudiant SET apogee=:apogee, nom=:nom, prenom=:prenom, date_naissance=:date_naissance, statut=:statut, filiere=:filiere WHERE idetud=:idetud";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'apogee' => $apogee,
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $date_naissance,
        'statut' => $statut,
        'filiere' => $filiere,
        'idetud' => $idetud,
    ]);

    // Redirection vers la page d'affichage des étudiants après la modification
    header("Location: afficher_etudiants.php");
    exit();
}
