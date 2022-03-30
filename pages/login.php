<?php

  include '../database/config.php';

  session_start();

  if ( (isset($_SESSION['nik'])) && (isset($_SESSION['nama'])) ) {
    header("Location: dashboard.php");
  }

  if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];

    $sql = "SELECT * FROM pengguna WHERE nik='$nik' AND nama='$nama'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['nik'] = $row['nik'];
        $_SESSION['nama'] = $row['nama'];
        header("Location: dashboard.php");
    }else{
        // echo "<script>alert('Woops! NIK or Name is Wrong.')</script>";
        header("Location: login.php?gagal=NIK Atau Nama Salah.");
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../assets/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Login | Peduli Diri</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-color">
      <div class="container">
        <a class="navbar-brand nav-title my-2" href="../index.php">
          <img src="../img/favicon.png" alt="Peduli Diri" width="40" height="40"> Peduli Diri
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="login.php">
                <button class="btn btn-outline-primary button mx-2 my-2">Masuk</button>
              </a>
            </li>
            <li class="nav-item">
              <a href="register.php">
                <button class="btn btn-primary button my-2">Daftar</button>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End of Navbar -->

    <!-- Form Login -->
    <div class="container">
      <div class="row my-3">
        <div class="col-12 col-sm-10 col-md-4 col-lg-4 col-xl-4 header-register my-5 offset-md-1 ">
          <div class="card card-primary cz">
            <div class="card-header"><h5>Masuk Peduli Diri</h5></div>
            <div class="card-body pt-0 px-4">
              <form action="" method="POST" class="form-group needs-validation" novalidate>
                <?php if (isset($_GET['sukses'])) { ?>
                <div class="alert alert-success" role="alert">
                  <?php echo $_GET['sukses'] ?>
                </div>
                <?php } ?>
                <?php if (isset($_GET['gagal'])) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $_GET['gagal'] ?>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="nik">NIK</label>
                  <input minlength="16" maxlength="16" placeholder="Masukkan dengan angka" type="text" class="form-control form" name="nik" required="" autofocus="" onkeydown="return numericOnly(event)" autocomplete="off">
                </div>
                <div class="form-group pt-4">
                  <label for="nama" class="d-block">Nama</label>
                  <input id="nama" placeholder="Masukkan dengan huruf" type="text" name="nama" class="form-control form" required="" autofocus="" onkeydown="return alphaOnly(event)" autocomplete="off">
                </div>
                <div class="form-group text-center pt-4">
                  <button type="submit" name="submit" class="login btn btn-primary button btn-lg btn-block">Masuk</button>
                </div>
              </form>
              <div class="text-center pt-4">
                Belum punya akun?
                <a class="p-1 link" href="register.php">Daftar</a>
              </div>
            </div>
          </div>
          <div class="simple-footer text-center">
            Copyright ©Community @2022
          </div>
        </div>
        <div class="col-md-7 d-none d-md-block mt-0 pt-0 text-center">
          <h1 class="text-bold mb-0 pb-0">Mencatat Perjalanan Anda<br> dengan kemudahan</h1>
          <img src="../img/ilustrations/login.svg" class="mt-0 pt-0" height="450">
        </div>
      </div>
    </div>
    <!-- End of Form -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alert -->
    <script src="../assets/sweetalert/sweetalert2.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
    </script>
    <script>
      // const Toast = Swal.mixin({
      //   toast: true,
      //   position: 'top-end',
      //   showConfirmButton: false,
      //   timer: 3000,
      // })

      // Toast.fire({
      //   icon: 'success',
      //   title: 'Signed in successfully'
      // })

      function numericOnly(event) {
        var key = event.keyCode;
        return ((key >= 48 && key <= 57) || key == 8);
      };

      function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
      };
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>