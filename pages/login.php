<?php
@session_start();
require_once 'connexion.php';
if (@$_SESSION['connect_admin'] == true) {
  header('Location: gestion.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $login = $_POST['login'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM utilisateur WHERE login = :login AND password = :password";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':login', $login);
  $stmt->bindParam(':password', $password);
  $stmt->execute();

  if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch();
    @$_SESSION['user_id'] = $row['id_utilisateur'];
    $_SESSION['user_profil'] = $row['profil'];

    @$_SESSION['connect_admin'] = true;
    header("location: gestion.php");
  } else {
    echo "
    <script>alert('Invalid username or password')</script>
    <script>window.location = 'login.php'</script>
    ";
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
                      <input type="text" class="form-control form-control-lg" name="login" placeholder="Login" aria-label="Login" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" aria-label="Password" required>
                    </div>

                    <?php
                    if (!empty($error))
                      echo  $error;
                    ?>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                      <button onclick="window.location.href = 'index.php';" type="submit" class="btn btn-secondary btn-lg">Espace Etudient</button>

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