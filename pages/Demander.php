<?php
session_start();
require_once 'connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connect'])) {
    header("Location: index.php");
    exit();
}

// Récupérer l'ID de l'utilisateur connecté
$idetud = $_SESSION['idetud'];

$sql = "SELECT modules_demandees, file_releve, file_carte FROM demande WHERE id_etud = :idetud ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':idetud' => $idetud));
$row = $stmt->fetch();
@$modules_demandees = explode(',', $row['modules_demandees']);


@$_SESSION['id_demande'] = $row['id_demande'];
// $modulesdemandees = $_POST['modules_demandees'];
@$file_releve_actuel = $row['file_releve'];
@$file_carte_actuel = $row['file_carte'];




// Vérifier si une demande a été soumise
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier si une demande non modifiée existe pour l'étudiant
    $sql = "SELECT COUNT(*) FROM demande WHERE id_etud = :idetud ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':idetud' => $idetud));
    $count = $stmt->fetchColumn();


    // Récupération des données du formulaire
    $modulesdemandees = implode(",", $_POST['modules_demandees']); // Conversion du tableau en chaîne de caractères
    // Stocker $modules_demandees dans la base de données
    $file_releve = isset($_POST['file_releve']) ? $_POST['file_releve'] : '';
    $file_carte = isset($_POST['file_carte']) ? $_POST['file_carte'] : '';

    if ($count > 0) {

        // Mettre à jour la demande existante
        $sql = "UPDATE demande SET date_demande = :datedemande, modules_demandees = :modules_demandees, file_releve = :file_releve, file_carte = :file_carte WHERE id_etud = :idetud ";
        $stmt = $pdo->prepare($sql);










        //verifier 
        if ($_FILES["file_releve"]["error"] == UPLOAD_ERR_OK && $_FILES["file_carte"]["error"] == UPLOAD_ERR_OK) {

            // Vérifier le type de fichier "releve" avec finfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type_releve = finfo_file($finfo, $_FILES["file_releve"]["tmp_name"]);
            $file_releve = $_FILES['file_releve']['name'];


            // Vérifier la taille du fichier "releve"
            if ($_FILES["file_releve"]["size"] > 222222222) {
                // 2 Mo
                echo "Le fichier de relevé est trop volumineux.";
                exit;
            }
            //verifier le type de fichier 'releve'
            if ($mime_type_releve != "application/pdf") {
                echo "Le fichier de relevé n'est pas un fichier  PDF.";
                exit;
            }

            // Vérifier le type de fichier "carte" avec finfo
            $mime_type_carte = finfo_file($finfo, $_FILES["file_carte"]["tmp_name"]);
            $file_carte = $_FILES['file_carte']['name'];


            // Vérifier si le type de fichier "carte" est une image
            if ($mime_type_carte != "image/jpeg" && $mime_type_carte != "image/png") {
                echo "La carte etudiant n'est pas un fichier JPEG ou PNG.";
                exit;
            }

            // Vérifier la taille du fichier "carte"
            if ($_FILES["file_carte"]["size"] > 2097152) { // 2 Mo
                echo "Le fichier de carte est trop volumineux.";
                exit;
            }

            // Récupération des noms de fichiers
            @$releve_nom = $_GET["nom"] . "_" . $_GET["prenom"] . "_releve.pdf";
            @$carte_nom = $_GET["nom"] . "_" . $_GET["prenom"] . "_carte." . pathinfo($_FILES["file_carte"]["name"], PATHINFO_EXTENSION);
        } else {
            $file_carte = $file_carte_actuel;
            $file_releve = $file_releve_actuel;
        }






        //execution
        $stmt->execute(array(
            ':idetud' => $idetud,
            ':datedemande' => date('Y-m-d H:i:s'),
            ':modules_demandees' => $modulesdemandees,
            ':file_releve' => $file_releve,
            ':file_carte' => $file_carte
        ));
    } else {


        // Requête d'insertion des noms de fichiers dans la base de données

        $datedemande = date('Y-m-d H:i:s');
        $sql = "INSERT INTO demande (id_etud, date_demande, modules_demandees, file_releve, file_carte) VALUES (:idetud, :datedemande, :modules_demandees, :releve_nom, :carte_nom)";
        $stmt = $pdo->prepare($sql);









        if (@$_FILES["file_releve"]["error"] == UPLOAD_ERR_OK && @$_FILES["carte"]["error"] == UPLOAD_ERR_OK) {

            // Vérifier le type de fichier "releve" avec finfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type_releve = finfo_file($finfo, $_FILES["file_releve"]["tmp_name"]);



            // Vérifier la taille du fichier "releve"
            if ($_FILES["file_releve"]["size"] > 222222222) {
                // 2 Mo
                echo "Le fichier de relevé est trop volumineux.";
                exit;
            }
            //verifier le type de fichier 'releve'
            if ($mime_type_releve != "application/pdf") {
                echo "Le fichier de relevé n'est pas un fichier  PDF.";
                exit;
            }

            // Vérifier le type de fichier "carte" avec finfo
            $mime_type_carte = finfo_file($finfo, $_FILES["file_carte"]["tmp_name"]);



            // Vérifier si le type de fichier "carte" est une image
            if ($mime_type_carte != "image/jpeg" && $mime_type_carte != "image/png") {
                echo "La carte etudiant n'est pas un fichier JPEG ou PNG.";
                exit;
            }

            // Vérifier la taille du fichier "carte"
            if ($_FILES["file_carte"]["size"] > 2097152) { // 2 Mo
                echo "Le fichier de carte est trop volumineux.";
                exit;
            }

            // Récupération des noms de fichiers
            $releve_nom = $_GET["nom"] . "_" . $_GET["prenom"] . "_releve.pdf";
            $carte_nom = $_GET["nom"] . "_" . $_GET["prenom"] . "_carte." . pathinfo($_FILES["carte"]["name"], PATHINFO_EXTENSION);




            $stmt->execute(array(
                ':idetud' => $idetud,
                ':datedemande' => $datedemande,
                ':modules_demandees' => $modulesdemandees,
                ':releve_nom' => $releve_nom,
                ':carte_nom' => $carte_nom

            ));




            // Déplacer les fichiers vers le répertoire "files_releve_carte"
            if (move_uploaded_file($_FILES["file_releve"]["tmp_name"], "files_releve_carte/" . $releve_nom) && move_uploaded_file($_FILES["carte"]["tmp_name"], "files_releve_carte/" . $carte_nom)) {
                // Afficher un message de confirmation
                echo "Les fichiers ont été enregistrés avec succès.";
            }
        }
    }
}
// Fermeture de la connexion à la base de données
$pdo = null;
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
    <title>CRUD Application Using PHP OOPS PDO MySQL & FETCH API of ES6</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</head>

<body>




    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <button class="btn btn-primary btn-sm ms-auto" type="button" onclick="history.back()">Back</button>

                        <div class="d-flex align-items-center justify-content-center">

                            <p class="font-weight-bold" style="font-family: Arial, sans-serif; text-align: center;">MA DEMANDE</p>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="form-group">
                                    <?php
                                    $file_cloture = fopen("cloturer.txt", "r");
                                    $on_off = fgets($file_cloture);
                                    fclose($file_cloture);


                                    if ($on_off == "on") { ?>
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <p class="font-weight-bold" style="font-family: Arial, sans-serif; text-align: center;">Veuillez sélectionner au maximum 4 modules. Merci</p>

                                            <div>
                                                <label for="modules_demandees">Modules demandés : </label><br>
                                                <input type="checkbox" id="module1" name="modules_demandees[]" value="Module 1" <?php if (in_array('Module 1', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module1">Module 1</label><br>
                                                <input type="checkbox" id="module2" name="modules_demandees[]" value="Module 2" <?php if (in_array('Module 2', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module2">Module 2</label><br>
                                                <input type="checkbox" id="module3" name="modules_demandees[]" value="Module 3" <?php if (in_array('Module 3', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module3">Module 3</label><br>
                                                <input type="checkbox" id="module4" name="modules_demandees[]" value="Module 4" <?php if (in_array('Module 4', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module4">Module 4</label><br>
                                                <input type="checkbox" id="module5" name="modules_demandees[]" value="Module 5" <?php if (in_array('Module 5', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module5">Module 5</label><br>

                                                <input type="checkbox" id="module6" name="modules_demandees[]" value="Module 6" <?php if (in_array('Module 6', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module6">Module 6</label><br>
                                                <input type="checkbox" id="module7" name="modules_demandees[]" value="Module 7" <?php if (in_array('Module 7', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module7">Module 7</label><br>
                                                <input type="checkbox" id="module8" name="modules_demandees[]" value="Module 8" <?php if (in_array('Module 8', $modules_demandees)) echo 'checked'; ?>>
                                                <label for="module8">Module 8</label><br>
                                                <!-- Ajoutez d'autres cases à cocher pour les autres modules -->
                                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <br>
                                    <br>

                                    <label for="file_carte">Carte étudiant :</label><br>
                                    <input class="btn btn-primary btn-sm ms-auto" type="file" id="file_carte" name="file_carte" accept=".jpg,.jpeg,.png">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file_releve">Relevé de notes (S1, S2 et S3) :</label>
                                        <input class="btn btn-primary btn-sm ms-auto" type="file" id="file_releve" name="file_releve" accept=".pdf" maxlength="10240" <?php if ($file_releve_actuel != '') echo 'value="' . $file_releve_actuel . '"'; ?>>
                                    </div>
                                </div>


                            </div>



                            <button class="btn btn-primary btn-sm ms-auto" type="submit" name="submit" id="submit" value="submit">
                                Envoyer ma demande
                            </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>
    </div>

</body>

</html>

<script>
    const confirmCheckbox = document.getElementById('confirm');
    const submitButton = document.getElementById('submit');

    confirmCheckbox.addEventListener('change', () => {
        submitButton.disabled = !confirmCheckbox.checked;
    });
</script>
<script>
    // Récupérer toutes les cases à cocher
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Écouter les changements de statut des cases à cocher
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', (event) => {
            // Récupérer le nombre de cases à cocher cochées
            const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

            // Si le nombre de cases cochées est supérieur à 4, désactiver la case cochée la plus récente
            if (checkedCount > 4) {
                event.target.checked = false;
            }
        });
    });
</script>
<?php } else {
?>
<div style="background-color: red;"><?php echo "Les demandes sont closes, veuillez contacter le service de scolarité"; ?></div><?php }
?>