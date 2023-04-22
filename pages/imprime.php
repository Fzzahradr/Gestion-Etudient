<?php
session_start();
require dirname(__FILE__) . '/fpdf.php';
require 'connexion.php';

if (isset($_POST['filier'])) {
  // Récupération de la filière choisie depuis le formulaire
  $filiere = $_POST['filier'];

  // Récupération des données des étudiants pour la filière choisie
  $query = "SELECT apogee, nom, prenom, date_naissance, statut, filiere FROM etudiant WHERE filiere = :filiere";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':filiere', $filiere);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Création du document PDF
  $pdf = new FPDF();
  $pdf->AddPage();
  // Ajouter un logo à gauche de la première page
  $imageWidth = 30; // Largeur de l'image en pixels
  $imageHeight = 30; // Hauteur de l'image en pixels
  $pdf->Image('../assets/img/logo.png', 10, 10, $imageWidth, $imageHeight);
  $imageWidth = 30; // Largeur de l'image en pixels
  $imageHeight = 30; // Hauteur de l'image en pixels
  $pdf->Image('../assets/img/logoo.jpg', 170, 10, $imageWidth, $imageHeight);

  // Définition de la police de caractères
  $pdf->SetFont('Arial', 'B', 16);
  // Titre
  $pdf->SetFont('Times', 'B', 20);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->MultiCell(0, 10, 'Universite Sultan Moulay Slimane' . "\n" . 'Ecole Superieure De Thenchnologie' . "\n" . 'Fkih Ben Salah', 0, 'C');
  $pdf->Ln(20); // Saut de ligne après le titre

  // Saut de ligne
  $pdf->Ln(15);

  // Titre
  $pdf->SetFont('Times', 'B', 16);
  $pdf->SetTextColor(255, 0, 0);

  $pdf->Cell(0, 10, 'Liste des etudiants', 0, 1, 'C');
  $pdf->Ln(10);
  // Définition des styles de cellule
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetFillColor(0, 0, 0); 
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetDrawColor(0, 0, 0);
  $pdf->SetLineWidth(0.1);
 




  // Ajout des en-têtes de colonne avec les styles de cellule définis
  $pdf->SetFillColor(255, 255, 255); // blanc
  $pdf->Cell(30, 10, 'Apogee', 1, 0, 'C', true);
  $pdf->Cell(40, 10, 'Nom', 1, 0, 'C', true);
  $pdf->Cell(40, 10, 'Prenom', 1, 0, 'C', true);
  $pdf->Cell(30, 10, 'Date  ', 1, 0, 'C', true);
  $pdf->Cell(30, 10, 'Statut', 1, 0, 'C', true);
  $pdf->Cell(30, 10, 'Filiere', 1, 0, 'C', true);
  $pdf->Ln();

  // Ajout des données à la table avec les styles de cellule définis
  foreach ($data as $row) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 10, $row['apogee'], 1, 0, 'C', false);
    $pdf->Cell(40, 10, $row['nom'], 1, 0, 'C', false);
    $pdf->Cell(40, 10, $row['prenom'], 1, 0, 'C', false);
    $pdf->Cell(30, 10, $row['date_naissance'], 1, 0, 'C', false);
    $pdf->Cell(30, 10, $row['statut'], 1, 0, 'C', false);
    $pdf->Cell(30, 10, $row['filiere'], 1, 0, 'C', false);
    $pdf->Ln();
  }


  // Envoi du document PDF au navigateur
  $pdf->Output();
}
