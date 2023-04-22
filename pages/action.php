<?php
session_start();
  require_once 'db.php';
  require_once 'util.php';

  $db = new Database;
  $util = new Util;

  // Handle Add New User Ajax Request
  if (isset($_POST['add'])) {
    $apogee = $util->testInput($_POST['apogee']);
    $nom = $util->testInput($_POST['nom']);
    $prenom = $util->testInput($_POST['prenom']);
    @$date_naissance = $util->testInput($_POST['date_naissance']);
    $statut = $util->testInput($_POST['statut']);
    $filiere = $util->testInput($_POST['filiere']);

    if ($db->insert($apogee, $nom, $prenom, $date_naissance, $statut, $filiere)) {
      echo $util->showMessage('success', 'User inserted successfully!');
    } else {
      echo $util->showMessage('danger', 'Something went wrong!');
    }
  }

  // Handle Fetch All Users Ajax Request
  if (isset($_GET['read'])) {
    $users = $db->read();
    $output = '';
    if ($users) {
      foreach ($users as $row) {
        $output .= '<tr>
                      <td>' . $row['idetud'] . '</td>
                      <td>' . $row['apogee'] . '</td>
                      <td>' . $row['nom'] . '</td>
                      <td>' . $row['prenom'] . '</td>
                      <td>' . $row['date_naissance'] . '</td>
                      <td>' . $row['statut'] . '</td>
                      <td>' . $row['filiere'] . '</td>

                      <td>
                        <a href="#" idetud="' . $row['idetud'] . '" class="btn btn-success btn-sm rounded-pill py-0 editLink" data-toggle="modal" data-target="#editUserModal">Edit</a>

                        <a href="#" idetud="' . $row['idetud'] . '" class="btn btn-danger btn-sm rounded-pill py-0 deleteLink">Delete</a>
                      </td>
                    </tr>';
      }
      echo $output;
    } else {
      echo '<tr>
              <td colspan="6">No Users Found in the Database!</td>
            </tr>';
    }
  }

  // Handle Edit User Ajax Request
  if (isset($_GET['edit'])) {
    $idetud = $_GET['idetud'];

    $user = $db->readOne($idetud);
    echo json_encode($user);
  }

  // Handle Update User Ajax Request
  if (isset($_POST['update'])) {
    @$idetud = $util->testInput($_POST['idetud']);
    $apogee = $util->testInput($_POST['apogee']);
    $nom = $util->testInput($_POST['nom']);
    $prenom = $util->testInput($_POST['prenom']);
    $date_naissance = $util->testInput($_POST['date_naissance']);
    $statut = $util->testInput($_POST['statut']);
    $filiere = $util->testInput($_POST['filiere']);
    
    if ($db->update($idetud,$apogee, $nom, $prenom, $date_naissance, $statut, $filiere)) {
      echo $util->showMessage('success', 'User updated successfully!');
    } else {
      echo $util->showMessage('danger', 'Something went wrong!');
    }
  }

  // Handle Delete User Ajax Request
  if (isset($_GET['delete'])) {
    @$idetud = $_GET['idetud'];
    if ($db->delete($idetud)) {
      echo $util->showMessage('info', 'User deleted successfully!');
    } else {
      echo $util->showMessage('danger', 'Something went wrong!');
    }
    
  }
  

?>