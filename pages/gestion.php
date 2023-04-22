<?php
session_start();
require 'connexion.php';
if(!isset($_SESSION['connect_admin'])){
  header("Location: login.php");
}
// Vérifie si l'utilisateur est connecté et s'il a un identifiant
if (isset($_SESSION['user_profil']) && isset($_SESSION['user_id'])) {
  // Récupère l'identifiant de l'utilisateur
  $user_id = $_SESSION['user_id'];
} else {
  // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
  header("location: login.php");
  exit;
}

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
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" target="_blank">
        <img src="../assets/img/logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">EST FBS</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link active" href="../pages/gestion.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Table Etudient</span>

          </a>
        </li>
        <?php
        if (isset($_SESSION['user_profil']) && trim($_SESSION['user_profil']) == "Chef" && isset($_SESSION['user_id'])) { ?>












          <li class="nav-item">
            <a class="nav-link " href="#">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
              </div>
              <span data-bs-toggle="modal" data-bs-target="#exampleModall" data-bs-whatever="@mdo">Importer les données</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-app text-info text-sm opacity-10"></i>
              </div>
              <span data-bs-toggle="modal" data-bs-target="#Imprimer" data-bs-whatever="@mdo">Imprimer liste Etudient</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link " href="../pages/demandeEtudient.php">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Information Sur Les Demande</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../pages/utilisateur.php">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Gerer Utilisateur</span>
            </a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link " href="../pages/listedommande.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Les Demandes des Etudiants</span>
          </a>
        </li>
        <ul>



    </div>

  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <?php
    if (isset($_SESSION['user_profil']) && trim($_SESSION['user_profil']) == "Chef" && isset($_SESSION['user_id'])) { ?>
      <!--  csv -->
      <div class="modal fade" id="exampleModall" tabindex="-1" aria-labelledby="exampleModallLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModallLabel">Importer les données des Etudiants</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="uploadfichCsv.php" method="post" enctype="multipart/form-data">

              <div class="mb-3">
                <label> Filiere</label>
                <input type="text" name="filiere" class="form-control" placeholder="Enter Le Nom de Filier">
              </div>
              <div>

                <label>Importer un fichier CSV :</label>
                <input type="file" name="file" class="btn btn-secondary btn-lg" accept=".csv">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit">Importer les données</button> </div>
            </form>
          </div>

        </div>
      </div>
    </div>
      <!-- imrimer -->
     <div class="modal fade" id="Imprimer" tabindex="-1" aria-labelledby="ImprimerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ImprimerModalLabel">Imprimer les données des Etudiants</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="imprime.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                  <label>Choisir une filière:</label>
                  <select name="filier" class="form-control" required>
                    <?php
                    require 'connexion.php';
                    // Récupération des filières depuis la base de données
                    $query = "SELECT DISTINCT filiere FROM etudiant";
                    $stmt = $pdo->query($query);
                    $filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Boucle pour ajouter les options de filière à la liste déroulante
                    foreach ($filieres as $filiere) {
                      echo "<option value='" . $filiere['filiere'] . "'>" . $filiere['filiere'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Imprimer les données</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

    <?php } ?>


    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">


          <!--recherche-->

          <form action="search.php" method="GET">
            <div class="d-flex align-items-center justify-content-end">
              <div class="input-group">
                <button type="submit" class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></button>
                <input type="text" class="form-control" name="search" placeholder="Code Apogee au Filiere" required>
              </div>
            </div>
          </form>
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
                    <div class="modal-header">
                      <h5 class="modal-title">Ajouter un Etudient</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="add-user-form" class="p-2" novalidate>
                        <div class="row mb-3 gx-3">
                          <div class="mb-3">
                            <input type="number" name="apogee" class="form-control form-control-lg" placeholder="Enter le numero apogee " required>
                            <div class="invalid-feedback">Apogee is required!</div>
                          </div>

                          <div class="mb-3">
                            <input type="text" name="nom" class="form-control form-control-lg" placeholder="Enter le Nom " required>
                            <div class="invalid-feedback">Nom is required!</div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <input type="text" name="prenom" class="form-control form-control-lg" placeholder="Enter Le Prenom" required>
                          <div class="invalid-feedback">Prenom is required!</div>
                        </div>
                        <div class="mb-3">
                          <input type="date" name="date_naissance" class="form-control form-control-lg" placeholder="Enter la date naissance" required>
                          <div class="invalid-feedback">Date is required!</div>
                        </div>
                        <div class="mb-3">
                          <input type="text" name="statut" class="form-control form-control-lg" placeholder="Enter lestatut" required>
                          <div class="invalid-feedback">statut is required!</div>
                        </div>

                        <div class="mb-3">
                          <input type="text" name="filiere" class="form-control form-control-lg" placeholder="Enter statut" required>
                          <div class="invalid-feedback">filiere is required!</div>
                        </div>

                        <div class="mb-3">
                          <input type="submit" value="Add User" class="btn btn-primary btn-block btn-lg" id="add-user-btn">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Add New User Modal End -->

              <!-- Edit User Modal Start -->
              <div class="modal fade" tabindex="-1" id="editUserModal">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modifier </h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="edit-user-form" class="p-2" novalidate>
                        <input type="hidden" name="idetud" id="idetud">
                        <div class="row mb-3 gx-3">
                          <div class="mb-3">
                            <input type="numbre" name="apogee" id="apogee" class="form-control form-control-lg" placeholder="Enter Apogee" required>
                            <div class="invalid-feedback">Apogee is required!</div>
                          </div>
                          <div class="mb-3">
                            <input type="text" name="nom" id="nom" class="form-control form-control-lg" placeholder="Enter Nom" required>
                            <div class="invalid-feedback">Nom is required!</div>
                          </div>
                          <div class="mb-3">
                            <input type="text" name="prenom" id="prenom" class="form-control form-control-lg" placeholder="Enter Prenom" required>
                            <div class="invalid-feedback">Prenom is required!</div>
                          </div>
                          <div class="mb-3">
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control form-control-lg" placeholder="Enter date naissance " required>
                            <div class="invalid-feedback">date naissance is required!</div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <input type="text" name="statut" id="statut" class="form-control form-control-lg" placeholder="Enter statut" required>
                          <div class="invalid-feedback">statut is required!</div>
                        </div>

                        <div class="mb-3">
                          <input type="text" name="filiere" id="filiere" class="form-control form-control-lg" placeholder="Enter Filiere" required>
                          <div class="invalid-feedback">Filiere is required!</div>
                        </div>

                        <div class="mb-3">
                          <input type="submit" value="Update User" class="btn btn-success btn-block btn-lg" id="edit-user-btn">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              if (isset($_SESSION['user_profil']) && trim($_SESSION['user_profil']) == "Chef" && isset($_SESSION['user_id'])) { ?>
                <!-- Edit User Modal End -->
                <div class="container">
                  <div class="row mt-4">
                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="text-primary">LES Information Des Etudients</h4>
                      </div>
                      <div>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addNewUserModal">Add New User</button>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-lg-12">
                      <div id="showAlert"></div>
                    </div>




                    <form action="cloturer.php" method="post">
                      <?php
                      $file_cloture = fopen("cloturer.txt", "r");
                      $on_off = fgets($file_cloture);
                      fclose($file_cloture);

                      if ($on_off == "on") {
                        echo "<input type='radio' name='cloture' id='on' value='on' checked>";
                        echo "<label for='cloture'>Ouvrir</label>";
                        echo "<input type='radio' name='cloture' id='off' value='off'>";
                        echo "<label for='cloture'>Clôturer</label>";
                      } else {
                        echo "<input type='radio' name='cloture' id='on' value='on'>";
                        echo "<label for='cloture'>Ouvrir</label>";
                        echo "<input type='radio' name='cloture' id='off' value='off' checked>";
                        echo "<label for='cloture'>Clôturer</label>";
                      }
                      ?>
                      <input type="submit" class="btn btn-primary" value="Appliquer">
                    </form>








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
                              <th>Prenom</th>
                              <th>Date naissance</th>
                              <th>Statut</th>
                              <th>Filire</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <script src="main.js"></script>
              <?php } else {
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

                <div class="container mt-4">
                  <?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
                    <div class="row">
                      <div class="col-lg-12">
                        <p>Résultats pour la recherche "<?php echo $_GET['search']; ?>"</p>
                      </div>
                    </div>
                  <?php } ?>

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
                          </thead>
                          <tbody>
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
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- Core JS Files   -->
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

              <script src="../assets/js/core/popper.min.js"></script>
              <script src="../assets/js/core/bootstrap.min.js"></script>
              <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
              <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>

              <!-- Github buttons -->
              <script async defer src="https://buttons.github.io/buttons.js"></script>
              <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc  -->
              <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>