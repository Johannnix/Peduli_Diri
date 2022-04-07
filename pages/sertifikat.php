<?php

  session_start();

  include '../database/config.php';
  if(isset($_POST["submit"])){
    $id = $_SESSION['id'];
    // $name = $_POST["name"];
    if($_FILES["image"]["error"] == 4){
      header("Location: sertifikat.php?gagal=Gambar Tidak Ada.");
    }
    else{
      $fileName = $_FILES["image"]["name"];
      $fileSize = $_FILES["image"]["size"];
      $tmpName = $_FILES["image"]["tmp_name"];
  
      $validImageExtension = ['jpg', 'jpeg', 'png'];
      $imageExtension = explode('.', $fileName);
      $imageExtension = strtolower(end($imageExtension));
      if ( !in_array($imageExtension, $validImageExtension) ){
        header("Location: sertifikat.php?gagal=Ekstensi Gambar Tidak Valid.");
      }
      else if($fileSize > 2000000){
        header("Location: sertifikat.php?gagal=Ukuran Gambar Terlalu Besar.");
      }
      else{
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;
  
        move_uploaded_file($tmpName, '../img/upload/' . $newImageName);
        $query = "INSERT INTO upload VALUES('', '$id', '', '$newImageName')";
        mysqli_query($conn, $query);
        header("Location: sertifikat.php?sukses=Berhasil Ditambahkan.");
      }
    }
  }

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
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/responsive.bootstrap4.min.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../css/magnific-popup.css">

    <!-- Font Awesome -->
    <link href="../assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Sweet Alert -->
    <link href="../assets/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Sertifikat Vaksin | Peduli Diri</title>
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
          <img src="../img/favicon.png" alt="" class="brand-image img-circle " style="opacity: .8">
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
                <a href="sertifikat.php" class="nav-link">
                  <i class="nav-icon fa-solid fa-crutch"></i>
                  <p>
                    Sertifikat Vaksin
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

      <!-- Modal -->
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
              <h1>Sertifikat Vaksin</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Sertifikat</li>
              </ol>
            </div>
          </div>
        </section>
        <section class="content">
          <div class="card mx-2">
            <div class="card-header">
              <h3 class="card-title">Sertifikat Vaksin</h3>
            </div>
            <div class="card-body">
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
                <div class="row d-flex justify-content-between">
                  <div class="col-8">
                    <div class="row">
                      <?php
                        include '../database/config.php';
                        $sql = "SELECT * FROM upload WHERE id=$_SESSION[id]";
                        $query = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($query);
                        foreach($query as $value) :
                      ?>
                      <div class="col-md-4">
                        <img src="../img/upload/<?= $value["image"]; ?>" alt="" class="sertif img-fluid">
                        <div class="d-area d-flex justify-content-end">
                          <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle detail" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-ellipsis-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <li><a class="dropdown-item" href="../img/upload/<?= $value["image"]; ?>" download="Certificate">Unduh</a></li>
                              <li><a class="dropdown-item sertifikat" href="../img/upload/<?= $value["image"]; ?>">Lihat</a></li>
                              <li><a class="dropdown-item" href="../database/hapus_sertifikat.php?no=<?= $value['no']?>">Hapus</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="t-area d-flex align-content-center flex-wrap">
                          <div class="text-box d-flex align-content-center flex-wrap">
                            <span class="judul-serti d-flex align-content-center flex-wrap">Sertifikat</span>
                          </div>
                        </div>
                      </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                  <?php
                    if ($count < 3) { ?>
                      <div class="col-4">
                        <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                          <div class="form-group row d-flex justify-content-end">
                            <div class="col-sm-10 ">
                              <div class="form-group">
                                <div class="m-1 text-danger text-small">*Max upload gambar 2MB</div>
                                <div class="custom-file mb-2">
                                  <input type="file" name="image" required accept=".jpg, .jpeg, .png" class="custom-file-input" id="customFile">
                                  <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <button type="submit" name="submit" class="btn btn-secondary keluar add upload">Upload</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                  <?php }else{ ?>
                    <div class="col-4 hilang">
                      <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group row d-flex justify-content-end">
                          <div class="col-sm-10 ">
                            <div class="form-group">
                              <div class="custom-file mb-2">
                                <input type="file" name="image" required accept=".jpg, .jpeg, .png" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                              <button type="submit" name="submit" class="btn btn-secondary keluar add upload">Upload</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  <?php } ?>
                </div>
            </div>
          </div>
        </section>
        <!-- /.content -->
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
    <script src="../js/bs-custom-file-input.min.js"></script>
    <!-- Magnific Popup -->
    <script src="../js/jquery.magnific-popup.js"></script>
    <script>
      function numericOnly(event) {
        var key = event.keyCode;
        return ((key >= 48 && key <= 57) || key == 8 || key == 190);
      };

      function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
      };
    </script>
    <script>
      $(function () {
        $("#example1").DataTable({
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          // "responsive": true, "lengthChange": false, "autoWidth": false,
          // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      });
    </script>
    <script>
      $(function () {
        bsCustomFileInput.init();
      });
    </script>
    <script>
      $(document).ready(function() {
        $('.sertifikat').magnificPopup({
          type:'image'});
      });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>