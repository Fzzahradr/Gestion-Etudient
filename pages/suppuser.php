<?php
require 'connexion.php';

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
    $x = $pdo->prepare($sql);
    $x->bindValue(":id", $id, PDO::PARAM_INT);
    $x->execute();
    
    header("Location: utilisateur.php");
}
?>
