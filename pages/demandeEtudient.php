<?php
// Connexion à la base de données
require 'connexion.php';
session_start();
// Requête SQL pour compter le nombre total des étudiants
$sql1 = "SELECT COUNT(*) AS count FROM etudiant";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();

// Récupération du résultat pour le nombre total des étudiants
$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

// Requête pour compter le nombre total des demandes
$sql2 = "SELECT COUNT(*) AS total_demandes FROM demande";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();

// Récupération du résultat pour le nombre total des demandes
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

// Requête SQL pour obtenir le nombre de demandes par filière
$sql3 = "SELECT e.filiere, COUNT(*) AS nombre_demandes
FROM demande d
JOIN etudiant e ON d.id_etud = e.idetud
GROUP BY e.filiere";

$stmt3 = $pdo->prepare($sql3);
$stmt3->execute();

// Création d'un tableau pour stocker les résultats
$tableau = array(
    array("Informations", "Nombre total"),
    array("Nombre total des étudiants", $result1['count']),
    array("Nombre total des demandes", $result2['total_demandes'])
);

// Ajout des données pour le nombre de demandes par filière
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $tableau[] = array($row["filiere"], $row["nombre_demandes"]);
}

// Requête SQL pour obtenir le nombre de demandes sans réponse
$sql4 = "SELECT COUNT(*) AS nombre_demandes_sans_reponse FROM demande WHERE reponse_admin IS NULL";

$stmt4 = $pdo->prepare($sql4);
$stmt4->execute();

// Récupération du résultat pour le nombre de demandes sans réponse
$result4 = $stmt4->fetch(PDO::FETCH_ASSOC);

// Ajout des données pour le nombre de demandes sans réponse
$tableau[] = array("Nombre de demandes sans réponse", $result4["nombre_demandes_sans_reponse"]);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100 virtual-reality">
    <div>
        <!-- Navbar -->

        <!-- End Navbar -->
    </div>
    <div>
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-primary">Avoir une vision globale sur les demandes</h4>
                    </div>

                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">

                            <tbody>
                                <?php
                                if (isset($tableau)) {
                                    foreach ($tableau as $row) :
                                        $demandes_par_filiere = ""; // variable pour stocker le nombre de demandes par filière
                                        if (isset($row[2])) {
                                            $demandes_par_filiere = $row[2];
                                        }
                                        $demandes_sans_reponse = ""; // variable pour stocker le nombre de demandes sans réponse
                                        if (isset($row[3])) {
                                            $demandes_sans_reponse = $row[3];
                                        }
                                ?>
                                        <tr>
                                            <td><?php echo $row[0]; ?></td>
                                            <td><?php echo $row[1]; ?></td>
                                            <td><?php echo $demandes_par_filiere; ?></td>
                                            <td><?php echo $demandes_sans_reponse; ?></td>
                                        </tr>
                                <?php
                                    endforeach;
                                } else {
                                    echo "<tr><td colspan='4'>Aucune donnée à afficher</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-danger btn-sm ms-auto" type="button" onclick="history.back()">Back</button>

                    </div>
                </div>
            </div>

        </div>


    </div>

</body>

</html>