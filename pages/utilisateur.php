<?php
session_start();

include "connexion.php";
if (!isset($_SESSION['connect_admin'])) {
    header("Location: login.php");
}
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
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>


<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <!--  -->
    <main class="main-content position-relative border-radius-lg ">
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
                                <label> Filier</label>
                                <input type="text" name="filiere" class="form-control" placeholder="Enter Le Nom de Filier">
                            </div>
                            <div>

                                <label>Importer un fichier CSV :</label>
                                <input type="file" name="file" class="btn btn-secondary btn-lg" accept=".csv">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Importer les données</button>
                            </div>
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
                                <select name="filier" class="form-control">
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




        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    </ol>
                    <button   class="btn btn-danger btn-sm ms-auto" onclick="window.location.href='gestion.php'" >Back</button>

                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">

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

            </div>
        </nav>

        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"></br>
                            <h6>Table Utilisateur</h6>
                            <div class="modal fade" tabindex="-1" id="addNewUserModal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!--table demnde-->
                            <div>
                                <div class="container">
                                    <div class="row mt-4">
                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                            <a href="ajouteretud.php"><button class="btn btn-success"> Ajouter un utilisateur</button></a>
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
                                                            <?php
                                                            // Requête SQL pour récupérer les données de la table utilisateur
                                                            $sql = "SELECT * FROM utilisateur";
                                                            $stmt = $pdo->prepare($sql);
                                                            $stmt->execute();
                                                            $utilisateurs = $stmt->fetchAll();
                                                            ?>
                                                            <th scope="col">#</th>
                                                            <th scope="col">login</th>
                                                            <th scope="col">password</th>
                                                            <th scope="col">profile</th>
                                                            <th scope="col">statut</th>
                                                            <th scope="col">Control</th>
                                                        </tr>
                                                        <?php foreach ($utilisateurs as $utilisateur) : ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $utilisateur['id_utilisateur']; ?></th>
                                                                <td><?php echo $utilisateur['login']; ?></td>
                                                                <td><?php echo $utilisateur['password']; ?></td>
                                                                <td><?php echo $utilisateur['profil']; ?></td>
                                                                <td><?php echo $utilisateur['statut']; ?></td>
                                                                <td>
                                                                    <a href="edituser.php?id=<?php echo $utilisateur['id_utilisateur']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                                    <a href="suppuser.php?id=<?php echo $utilisateur['id_utilisateur']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                                                </td>

                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>


                                            </div>
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