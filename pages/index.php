<?php
session_start();
require_once 'connexion.php';


if (isset($_POST['apogee']) && isset($_POST['date_naissance'])) {
  $apogee = $_POST['apogee'];
  $date_naissance = $_POST['date_naissance'];

  $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE apogee = :apogee AND date_naissance = :date_naissance");
  $stmt->execute(['apogee' => $apogee, 'date_naissance' => $date_naissance]);
  $user = $stmt->fetch();

  if ($user) {
    $_SESSION['idetud'] = $user['idetud'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['prenom'] = $user['prenom'];
    $_SESSION['apogee'] = $user['apogee'];
    $_SESSION['date_naissance'] = $user['date_naissance'];
    $_SESSION['statut'] = $user['statut'];
    $_SESSION['filiere'] = $user['filiere'];
    // et ainsi de suite pour les autres champs
    $_SESSION['connect'] = true;
    header("Location: espaceetudient.php");
  } else {
    $error = "Numéro Apogée ou date de naissance incorrecte.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    ESTFBS
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">

        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>

                </div>
                <div class="card-body">
                  <form role="form" method="POST">
                    <div class="mb-3">
                      <input type="date" class="form-control form-control-lg" name="date_naissance" placeholder="date naissance" aria-label="date naissance" required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" name="apogee" placeholder="N apogee" aria-label="N apogee" required>
                    </div>

                    <?php
                    if (!empty($error))
                      echo  $error;
                    ?>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                    <div class="text-center">
                      <button onclick="window.location.href = 'login.php';" type="submit" class="btn btn-secondary btn-lg">ESpace Admin</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                <img src="../assets/img/imgg .jpeg">

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
<script>
  const confirmCheckbox = document.getElementById('confirm');
  const submitButton = document.getElementById('submit');

  confirmCheckbox.addEventListener('change', () => {
    submitButton.disabled = !confirmCheckbox.checked;
  });
</script>