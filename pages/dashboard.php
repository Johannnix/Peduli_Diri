<?php

  session_start();

  $url = file_get_contents('https://disease.sh/v3/covid-19/countries/indonesia');
  $data = json_decode($url, true);

  if ( (!isset($_SESSION['nik'])) && (!isset($_SESSION['nama'])) ) {
    echo "<script type='text/javascript'>alert('Sorry! You Are Not Logged In Yet.');
          document.location.href = 'login.php';</script>";
  }
  
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Theme style -->
    <link href="../css/adminlte.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/responsive.bootstrap4.min.css">
    
    <!-- Swipper -->
    <link rel="stylesheet" href="../css/swiper-bundle.min.css"/>

    <!-- Font Awesome -->
    <link href="../assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Sweet Alert -->
    <link href="../assets/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Dashboard | Peduli Diri</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  </head>
  <body class="hold-transition sidebar-mini">

    <div class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
      </nav>

      <aside class="main-sidebar sidebar-light-primary elevation-1">
        <!-- Brand Logo -->
        <a href="dashboard.php" class="brand-link">
          <img src="../img/favicon.png" alt="Peduli Diri" class="brand-image img-circle " style="opacity: .8">
          <span class="nav-title brand-text font-weight-bold">Peduli Diri</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../img/user.png" class="img-circle " alt="User Image">
            </div>
            <div class="info">
              <a href="profile.php" class="d-block"><?php echo $_SESSION['nama']?></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="tulis_catatan.php" class="nav-link">
                  <i class="nav-icon fa-solid fa-map-location-dot"></i>
                  <p>
                    Catat Perjalanan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="riwayat_perjalanan.php" class="nav-link">
                  <i class="nav-icon fa-solid fa-book-atlas"></i>
                  <p>
                    Riwayat Perjalanan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="export_riwayat_perjalanan.php" class="nav-link">
                  <i class="nav-icon fa-solid fa-book"></i>
                  <p>
                    Export Riwayat Perjalanan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-danger logout" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <div class="row">
                <div class="col mx-1">
                  <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Ingin Keluar ?</h5>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col d-flex justify-content-end">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <a href="../database/logout.php" class="btn btn-secondary keluar">Keluar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="content-wrapper">
        <section class="content-header">
          <div class="row mx-1">
            <div class="col-sm-6">
              <h1>Catatan Perjalanan</h1>
            </div>
            <div class="col-sm-6 mb-3">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                    include '../database/config.php';
                    $sql = "SELECT count(*) FROM catatan WHERE id='$_SESSION[id]'";
                    $result = $conn->query($sql);
                    while($row = mysqli_fetch_array($result)) {
                      echo "<h3>".$row['count(*)']."</h3>";
                  ?>
                  <?php } ?>
                  <p>Jumlah Catatan Perjalanan</p>
                </div>
                <div class="icon">
                  <i class="ion ion-map"></i>
                </div>
                <a href="riwayat_perjalanan.php" class="small-box-footer">Info lebih <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= number_format($data['cases'], '0', '.', '.'); ?></h3>
                  <p>Positif Corona di Indonesia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="https://www.worldometers.info/coronavirus/country/indonesia/" target="_blank" rel="noopener noreferrer" class="small-box-footer">Info lebih <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= number_format($data['recovered'], '0', '.', '.'); ?></h3>
                  <p>Sembuh Corona di Indonesia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-medkit"></i>
                </div>
                <a href="https://www.worldometers.info/coronavirus/country/indonesia/" target="_blank" rel="noopener noreferrer" class="small-box-footer">Info lebih <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= number_format($data['deaths'], '0', '.', '.'); ?></h3>
                  <p>Kematian Corona di Indonesia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="https://www.worldometers.info/coronavirus/country/indonesia/" target="_blank" rel="noopener noreferrer" class="small-box-footer">Info lebih <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <div class="row mx-1">
            <div class="col">
              <div class="swiper" style="height: 50vh;">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <a href="#">
                      <img class="slide" src="../img/slide/1.jpg" alt="">
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#">
                      <img class="slide" src="../img/slide/2.jpg" alt="">
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#">
                      <img class="slide" src="../img/slide/3.jpg" alt="">
                    </a>
                  </div>
                </div>
                <div class="swiper-pagination slide-btn"></div>

                <div class="swiper-button-prev slide-btn"></div>
                <div class="swiper-button-next slide-btn"></div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>UKK RPL 2022</b> Aplikasi Peduli Diri
        </div>
        <strong>Copyright &copy; <?php echo date("Y")?> <a href="">Peduli Diri</a>.</strong> <?php echo $_SESSION['nama']?>.
      </footer>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
    <!-- Sweet Alert -->
    <script src="../assets/sweetalert/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../js/adminlte.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap4.min.js"></script>
    <!-- Swipper -->
    <script src="../js/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper('.swiper', {
      // Optional parameters
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },

      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },

      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
    </script>
    <!-- <script src="js/demo.js"></script> -->

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>