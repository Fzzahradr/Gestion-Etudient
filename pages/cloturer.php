<?php 
session_start();

if (isset($_POST['cloture'])){
    $cloture = $_POST['cloture'];
    $file_cloture = fopen("cloturer.txt","w");
    fwrite($file_cloture, "$cloture");
    fclose($file_cloture);
    header("Location:gestion.php");
}


?>