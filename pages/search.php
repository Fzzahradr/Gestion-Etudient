<?php
require 'connexion.php';
session_start();
// Récupération des données
$stmt = $pdo->query('SELECT * FROM etudiant');
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76">

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
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</head>


<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Serch</h6>
        </nav>
        <button class="btn btn-danger btn-sm ms-auto" onclick="window.history.back()">Back</button>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">



          <!--recherche-->


        </div>
        <ul class="navbar-nav justify-content-end">
          <?php
          // Vérifie si l'utilisateur est connecté
          if (isset($_SESSION['user_profil']) && isset($_SESSION['user_id'])) {
            // Affiche le profil de l'utilisateur connecté
            echo '
            <li class="nav-item">
               <a class="nav-link text-white font-weight-bold px-0">
               <i class="fa fa-user me-sm-1"></i>
                 <span class="d-sm-inline d-none">' . $_SESSION['user_profil'] . '</span>
                       </a>
                              </li>
                                     ';
            $user_id = $_SESSION['user_id'];
          } else {
            // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("location: login.php");
            exit;
          }
          ?>

          <li class="nav-item">
            <a href="deconnection.php" class="nav-link text-white font-weight-bold px-0">
              <i class="fa fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Déconnecter</span>
            </a>
          </li>
        </ul>
        </ul>
        </li>
        </ul>
      </div>
      </div>
    </nav>

    <!-- edit-->


    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0"></br>
              <h6>Table Etudiant</h6>
              <div class="modal fade" tabindex="-1" id="addNewUserModal">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body">
                    </div>
                  </div>
                </div>
              </div>
              <!-- Add New User Modal End -->


              <!-- Edit User Modal End -->
              <div class="container">
                <div class="row mt-4">

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
                      <?php

                      require 'connexion.php';
                      // Récupération des données du formulaire
                      if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $_GET['search'];
                        $search_terms = explode(' ', $search); // sépare les termes de recherche par espace

                        $where_clause = '';
                        $params = array();

                        // construction de la clause WHERE en fonction des termes de recherche
                        foreach ($search_terms as $term) {
                          if (preg_match('/^\d+$/', $term)) { // si le terme est un nombre, recherche par apogée
                            $where_clause .= ' OR apogee = :apogee';
                            $params[':apogee'] = $term;
                          } else { // sinon, recherche par filière
                            $where_clause .= ' OR filiere LIKE :filiere';
                            $params[':filiere'] = '%' . $term . '%';
                          }
                        }

                        $where_clause = substr($where_clause, 4); // supprime le premier " OR " de la clause WHERE

                        // Requête pour récupérer les données des étudiants correspondant aux termes de recherche
                        $requete = $pdo->prepare('SELECT * FROM etudiant WHERE ' . $where_clause);
                        $requete->execute($params);
                      } else { // si aucun terme de recherche n'a été soumis, récupération de tous les étudiants
                        $requete = $pdo->prepare('SELECT * FROM etudiant');
                        $requete->execute();
                      }
                      ?>
                      <table class="table table-striped table-bordered text-center">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Apogee</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Date naissance</th>
                            <th>Statut</th>
                            <th>Filiere</th>
                          </tr>
                          <?php
                          $i = 1;
                          while ($donnees = $requete->fetch()) {
                            echo '<tr>';
                            echo "<td>" . $i++ . "</td>";
                            echo '<td>' . $donnees['apogee'] . '</td>';
                            echo '<td>' . $donnees['nom'] . '</td>';
                            echo '<td>' . $donnees['prenom'] . '</td>';
                            echo '<td>' . $donnees['date_naissance'] . '</td>';
                            echo '<td>' . $donnees['statut'] . '</td>';
                            echo '<td>' . $donnees['filiere'] . '</td>';
                            echo '</tr>';
                          } ?>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>



              <!-- Core JS Files   -->
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

              <script src="../assets/js/core/popper.min.js"></script>
              <script src="../assets/js/core/bootstrap.min.js"></script>
              <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
              <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
              <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc  -->
              <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>