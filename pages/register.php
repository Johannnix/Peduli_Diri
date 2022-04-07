<?php

  include '../database/config.php';

  session_start();

  error_reporting(0);

  $nik    = "";
  $nama   = "";
  $alamat = "";
  $jenkel = "";
  $errors = array(); 

  if ( (isset($_SESSION['nik'])) && (isset($_SESSION['nama'])) ) {
    header("Location: dashboard.php");
  }

  if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $alamat = $_POST['alamat'];
  }

  if (empty($nik)) { array_push($errors, "NIK diperlukan"); }
  if (empty($nama)) { array_push($errors, "Nama diperlukan"); }
  if (empty($alamat)) { array_push($errors, "Alamat diperlukan"); }
  if (empty($jenkel)) { array_push($errors, "Jenis Kelamin diperlukan"); }

  $user_check_query = "SELECT * FROM pengguna WHERE nik='$nik'";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user) { // if user exists
    if ($user['nik'] === $nik) {
        array_push($errors, "NIK already exists");
        header("Location: register.php?gagal=NIK Sudah Terdaftar.");
    }
  }

  if (count($errors) == 0) {
    $sql = "INSERT INTO pengguna (nik, nama, alamat, jenkel)
            VALUES ('$nik', '$nama', '$alamat', '$jenkel')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: login.php?sukses=Pendaftaran Pengguna Berhasil.");
        $nik = "";
        $nama = "";
        $alamat = "";
        $jenkel = "";
    }else{
        header("Location: register.php");
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

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Register | Peduli Diri</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-color">
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
                <button class="btn btn-outline-primary button mx-lg-2 my-2">Masuk</button>
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

    <!-- Form -->
    <section class="section" style="background: transparent !important; margin-top:100px !important;">
      <div class="container my-5">
        <div class="row">
          <div class="col-12 col-sm-10 col-md-6 col-lg-6 col-xl-6 header-register">
            <div class="card card-primary shadow-sm">
              <div class="card-header"><h3>Daftar Peduli Diri</h3></div>
              <div class="card-body">
                <form method="POST" action="register.php" class="form-group needs-validation" novalidate>
                <?php if (isset($_GET['gagal'])) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $_GET['gagal'] ?>
                </div>
                <?php } ?>
                <div class="form-group px-2">
                    <label class="label" for="nik">NIK</label>
                    <input minlength="16" maxlength="16" placeholder="Masukkan dengan angka" type="text" value="" class="form-control form" name="nik" required="" autofocus="" onkeydown="return numericOnly(event)" autocomplete="off">
                    <div class="m-1 text-danger text-small">*harap masukkan nik dengan benar!</div>
                  </div>              
                  <div class="form-group px-2 pt-4">
                    <label class="label" for="nama">Nama Lengkap</label>
                    <input type="name" value="" placeholder="Masukkan dengan huruf" class="form-control form" name="nama" required="" autofocus="" onkeydown="return alphaOnly(event)" autocomplete="off">
                  </div>
                  <div class="form-group px-2 pt-4">
                    <label class="label" for="jenkel">Jenis Kelamin</label>
                      <select name="jenkel" class="form-control form selectric " required="" autofocus="">
                        <option disabled="" selected="">--Pilih Jenis Kelamin--</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                  </div>
                  <div class="form-group px-2 pt-4 has-error">
                    <label class="label" for="alamat">Alamat</label>
                    <input type="text" value="" placeholder="Masukkan alamat" class="form-control form" name="alamat" autofocus="" required="" autocomplete="off"></input>
                  </div>
                  <div class="form-group text-center pt-4">
                    <button onclick="return confirm('Apakah data Anda sudah benar ?')" type="submit" name="submit" class="btn btn-primary button btn-lg col-6">Daftar</button>
                  </div>
                </form>
                <div class="text-center pt-4">
                    Sudah punya akun?<a class="p-1 link" href="login.php">Login</a>
                </div>
              </div>
            </div>
            <div class="simple-footer">
              Copyright ©Community @2022
            </div>
          </div>
          <div class="col-md-6 d-none d-md-block text-center">
            <h5>Mari Memulai dengan Peduli Diri</h5>
            <h2 class="text-bold" style="font-weight:bold !important;">Mencatat Perjalanan Anda<br> dengan kemudahan</h2>
            <img src="../img/ilustrations/daftar.svg" height="540">
          </div>
        </div>
      </div>
    </section>
    <!-- End of Form -->    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../js/bootstrap.bundle.min.js"></script>
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