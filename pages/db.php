<?php

require_once 'config.php';

class Database extends Config
{
    // Insert User Into Database
    public function insert($apogee, $nom, $prenom, $date_naissance, $statut, $filiere)
    {
        $sql = 'INSERT INTO etudiant (apogee, nom, prenom, date_naissance, statut ,filiere) VALUES (:apogee, :nom, :prenom, :date_naissance, :statut ,:filiere)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'apogee' => $apogee,
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance,
            'statut' => $statut,
            'filiere' => $filiere

        ]);
        return true;
    }

    // Fetch All Users From Database
    public function read()
    {
        $sql = 'SELECT * FROM etudiant ORDER BY idetud DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    // Fetch Single User From Database
    public function readOne($idetud)
    {
        $sql = 'SELECT * FROM etudiant WHERE idetud = :idetud';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['idetud' => $idetud]);
        $result = $stmt->fetch();
        return $result;
    }

    // Update Single User
    public function update($idetud, $apogee, $nom, $prenom, $date_naissance, $statut, $filiere)
    {
        $sql = 'UPDATE etudiant SET apogee = :apogee, nom = :nom, prenom = :prenom, date_naissance = :date_naissance, statut = :statut ,filiere = :filiere WHERE idetud = :idetud';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'apogee' => $apogee,
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance,
            'statut' => $statut,
            'filiere' => $filiere,
            'idetud' => $idetud
        ]);

        return true;
    }

    // Delete User From Database
    public function delete($idetud)
    {
        $sql = 'DELETE FROM etudiant WHERE idetud = :idetud';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idetud' => $idetud]);
        return true;
    }
    
}
