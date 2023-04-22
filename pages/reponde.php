<?php
session_start();

require 'connexion.php';
if (isset($_SESSION['user_id'])) {
  // Récupère l'identifiant de l'utilisateur
  $id_utilisateur = $_SESSION['user_id'];
} else {
  // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
  header("location: login.php");
  exit;
}
// Vérifier si un formulaire a été soumis
if (isset($_POST['submit'])) {
  // Récupérer les données saisies dans le formulaire
  $idDemande = $_POST['id_demande'];
  $reponse = $_POST['reponse'];
  $dateReponse = date('Y-m-d H:i:s');

  // Insérer la réponse dans la table des demandes
  $stmt = $pdo->prepare("UPDATE demande SET reponse_admin = :reponse, id_utilisateur = :id_utilisateur, date_reponse = :date_reponse WHERE id_etud = :id_etud");
  $stmt->execute(['reponse' => $reponse, 'id_etud' => $idDemande, 'id_utilisateur' => $id_utilisateur, 'date_reponse' => $dateReponse]);

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: listedommande.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76">

  <title>
    EST
  </title>

  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</head>

<!-- Formulaire pour la réponse -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header pb-0">
          <button class="btn btn-danger btn-sm ms-auto" type="button" onclick="history.back()">Back</button>

          <div class="d-flex align-items-center justify-content-center">

            <p class="font-weight-bold" style="font-family: Arial, sans-serif; text-align: center;">Demande <?php ?></p>
          </div>


        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mx-auto">
              <div class="form-group">
                <form method="POST">
                  <input type="hidden" name="id_demande" value="<?php echo $_GET['id']; ?>">
                  <div class="form-group">
                    <label for="reponse">Réponse :</label>
                    <textarea class="form-control" name="reponse" id="reponse"></textarea>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    