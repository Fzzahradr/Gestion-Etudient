<?php
require 'connexion.php';

if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    $stmt->execute();
    $utilisateur = $stmt->fetch();
}

if (isset($_POST["update"])) {
    $id = $_POST["id_utilisateur"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $profil = $_POST["profil"];
    $statut = $_POST["statut"];

    $sql = "UPDATE utilisateur SET login = :login, password = :password, profil = :profil, statut = :statut WHERE id_utilisateur = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":login", $login, PDO::PARAM_STR);
    $stmt->bindValue(":password", $password, PDO::PARAM_STR);
    $stmt->bindValue(":profil", $profil, PDO::PARAM_STR);
    $stmt->bindValue(":statut", $statut, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: utilisateur.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Modifier utilisateur</title>
</head>

<body>
<h3 style="text-align: center; color: red;">Modifier un Ulisateur</h3>

    <div class="container mt-9">
        <form action="edituser.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur["id_utilisateur"] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">login</label>
                <input type="text" name="login" value="<?php echo @$utilisateur["login"] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">password</label>
                <input type="password" name="password" value="<?php echo @$utilisateur["password"] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="profil">Profil</label>
                <select class="form-control" name="profil">
                    <option value="Chef" <?php if (@$utilisateur['profil'] == 'Chef') echo 'selected'; ?>>Chef</option>
                    <option value="Agent" <?php if (@$utilisateur['profil'] == 'Agent') echo 'selected'; ?>>Agent</option>
                </select>
            </div>


            <div class="form-group">
                <label for="name">Statut</label>
                <input type="text" name="statut" value="<?php echo @$utilisateur["statut"] ?>" class="form-control">
            </div>


            <button class="btn btn-danger btn-sm ms-auto" type="button" onclick="history.back()">Back</button>

            <button type="submit" name="update" class="btn btn-primary">Submit</button>
        </form>
    </div>