<?php
session_start();
if (isset($_POST['add'])) {
    require "connexion.php";
    $login = $_POST["login"];
    $password = $_POST["password"];
    $profil = $_POST["profil"];
    $statut = $_POST["statut"];
    $sql = "INSERT INTO utilisateur(login, password, profil, statut) VALUES (:login, :password, :profil, :statut)";
    $statement = $pdo->prepare($sql);
    $data = [":login" => $login, ":password" => $password, ":profil" => $profil, ":statut" => $statut];
    $exe = $statement->execute($data);
    if ($exe) {

        header("location: utilisateur.php");
    }
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
    <title>Document</title>
</head>

<body>
<h3 style="text-align: center; color: red;">Ajoutre Un Ulisateur</h3>


    <div class="container mt-9">
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Login</label>
                <input type="text" name="login" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Mot de passe</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="profil">Profil</label>
                <select class="form-control" name="profil">
                    <option value="Chef">Chef</option>
                    <option value="Agent">Agent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Statut</label>
                <input type="text" class="form-control" name="statut">
            </div>
            <button class="btn btn-danger btn-sm ms-auto" type="button" onclick="history.back()">Back</button>

            <button type="submit" name="add" class="btn btn-primary">Ajouter </button>
        </form>
    </div>

</body>

</html>