<?php
session_start();

// Vérifier si l'utilisateur est connecté
include "connexion.php";
if (!$_SESSION["connect"]) {
  header('Location: index.php');
}


// Récupérer les données de l'utilisateur depuis la session
$user_id = $_SESSION['idetud'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$apogee = $_SESSION['apogee'];
$statut = $_SESSION['statut'];
$filiere = $_SESSION['filiere'];
$date_naissance = $_SESSION['date_naissance'];
// et ainsi de suite pour les autres champs

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">

  <title>
    EST FBS
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</head>
<body class="g-sidenav-show  bg-gray-100 virtual-reality">
  <div>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl  mt-3 mx-3 bg-primary" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">

            <img src="../assets/img/logo.png" alt="Logo" style="width: 70px; height: 70px;">

            <li class="breadcrumb-item text-sm text-white active" aria-current="page">EST FBS</li>
          </ol>

        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="deconnection.php" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Deconnecter</span>
              </a>
            </li>



            <li class="nav-item px-3 d-flex align-items-center">
            <li class="nav-item d-flex align-items-center">
              <a href="Demander.php" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Ma Demmande</span>
              </a>
            </li>
            </li>
            

          </ul>
          </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
  </div>
  <div>
    <div class="container">
      <div class="row mt-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
          <div>
          <?php echo "<h1>Bonjour <span style='color:red'>" . $nom . " " . $prenom . "</span> vos informations</h1>"; ?>

          </div>

        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">
          <div id="showAlert"></div>
        </div>
      </div>
      <div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      
      <table class="table table-striped table-bordered text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Apogee</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
            <th>Statut</th>
            <th>Filière</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Vérifier si les données de session existent et les utiliser
          if (isset($_SESSION['apogee'])) {
            $apogee = $_SESSION['apogee'];
            $nom = $_SESSION['nom'];
            $prenom = $_SESSION['prenom'];
            $date_naissance = $_SESSION['date_naissance'];
            $statut = $_SESSION['statut'];
            $filiere = $_SESSION['filiere'];

            // Afficher les données de l'étudiant dans le tableau
            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$apogee</td>";
            echo "<td>$nom</td>";
            echo "<td>$prenom</td>";
            echo "<td>$date_naissance</td>";
            echo "<td>$statut</td>";
            echo "<td>$filiere</td>";
            echo "</tr>";
          } else {
            // Si les données de session n'existent pas, rediriger l'utilisateur vers la page de connexion
            header("Location: index.php");
            exit();
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

    </div>


  </div>

</body>

</html>
