<?php 
  include 'database/config.php';

  session_start();

  $url = file_get_contents('https://disease.sh/v3/covid-19/all');
  $urlind = file_get_contents('https://disease.sh/v3/covid-19/countries/indonesia');

  $data = json_decode($url, true);
  $dataind = json_decode($urlind, true);

  $timestamp = preg_replace( '/[^0-9]/', '', $data['updated']);
  $timestampind = preg_replace( '/[^0-9]/', '', $dataind['updated']);

  $date = date("d-m-Y", $timestamp / 1000);
  $dateind = date("d-m-Y", $timestampind / 1000);

  if ( (isset($_SESSION['nik'])) && (isset($_SESSION['nama'])) ) {
    header("Location: pages/dashboard.php");
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">

    <!-- Swipper -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css"/>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>Peduli Diri</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
  </head>
  <body style="padding-top: 83px;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-color fixed-top">
      <div class="container">
        <a class="navbar-brand nav-title my-2" href="index.php">
          <img src="img/favicon.png" alt="Peduli Diri" width="40" height="40"> Peduli Diri
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="pages/login.php">
                <button class="btn btn-outline-primary button mx-2 my-2">Masuk</button>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/register.php">
                <button class="btn btn-primary button my-2">Daftar</button>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End of Navbar -->

    <!-- Modal --> 
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="padding-right: 16px; display: block;" aria-modal="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Peduli Diri</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row py-2">
              <div class="col-sm-5">
                  <img width="295" height="197" src="img/ilustrations/index.svg">
              </div>
              <div class="col-sm-7 my-2 sm-text-center modal-kanan">
                  <p class="pb-0 mb-0">Mari memulai dengan Peduli Diri</p>
                  <h3 class="text-primary">Mencatat Perjalanan Anda dengan kemudahan</h3>
                  <div class="row pt-2 modal-btn">
                      <a href="pages/register.php" class="btn btn-primary button col-4 ml-3 shadow-none">Daftar</a>
                      <a href="pages/login.php" class="btn btn-outline-primary button col-4 mx-3 shadow-none">Masuk</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of Modal --> 

    <!-- Slider main container -->
    <section class="section-slider px-3 py-3" style="background: transparent !important;">
      <div class="swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="#">
              <img class="slide" src="img/slide/1.jpg" alt="">
            </a>
          </div>
          <div class="swiper-slide">
            <a href="#">
              <img class="slide" src="img/slide/2.jpg" alt="">
            </a>
          </div>
          <div class="swiper-slide">
            <a href="#">
              <img class="slide" src="img/slide/3.jpg" alt="">
            </a>
          </div>
        </div>
        <div class="swiper-pagination slide-btn"></div>

        <div class="swiper-button-prev slide-btn"></div>
        <div class="swiper-button-next slide-btn"></div>
      </div>
    </section>
    <!-- End of Slider -->

    <!-- Content -->
    <section class="data-sebaran my-5">
      <div class="container">
        <h2 class="text-hitam">Data Sebaran</h2>
        <div class="row">
          <div class="col-sm-9">
              <div class="row">
                  <div class="col-sm-12 card-title">
                      <h1 class="global">Global</h1>
                      <p class="update"> Update Terakhir: <?= $date ?> Sumber: WHO
                      </p>
                  </div>
                  <div class="col-sm-4">
                      <div class="card-global">
                          <h2 class="hasil"><?= $data['affectedCountries'] ?></h2>
                          <p class="ket">Negara</p>
                      </div>

                  </div>
                  <div class="col-sm-4">
                      <div class="card-global">
                          <h2 class="hasil"><?= number_format($data['cases'], '0', '.', '.') ?></h2>
                          <p class="ket">Terkonfirmasi</p>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="card-global">
                          <h2 class="hasil"><?= number_format($data['deaths'], '0', '.', '.') ?></h2>
                          <p class="ket">Meninggal Dunia</p>
                      </div>
                  </div>
              </div>
              <hr class="m-1">
              <div class="row mt-4">
                  <div class="col-sm-12 card-title">
                      <h1 class="negara">Indonesia</h1>
                      <p class="update"> Update Terakhir: <?= $dateind ?>
                      </p>
                  </div>
                  <div class="col-sm-4">
                      <div class="card-indonesia">
                          <h2 class="hasil-ind"><?= number_format($dataind['cases'], '0', '.', '.') ?></h2>
                          <p class="ket-ind">Positif</p>
                      </div>

                  </div>
                  <div class="col-sm-4">
                      <div class="card-indonesia">
                          <h2 class="hasil-ind"><?= number_format($dataind['recovered'], '0', '.', '.') ?></h2>
                          <p class="ket-ind">Sembuh</p>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="card-indonesia">
                          <h2 class="hasil-ind"><?= number_format($dataind['deaths'], '0', '.', '.') ?></h2>
                          <p class="ket-ind">Meninggal Dunia</p>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-3 main-card-covid mt-5">
              <div class="card-covid">
                  <h2 class="covid">Situasi Virus</h2>
                  <h2 class="covid">COVID-19</h2>
                  <h2 class="mb-5 covid">di Indonesia</h2>
                  <a href="https://covid19.go.id/peta-sebaran" target="_blank" rel="noopener noreferrer" class="btn">Lihat Selengkapnya</a>
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End of Content -->

    <!-- Footer -->
    <footer class="bg-white">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <img src="img/logo.png" style="height: 50px; padding-bottom:5px;">
            <p>Peduli Diri adalah website catatan perjalanan yang memudahkan para pengguna untuk mencatat perjalanan hanya dengan beberapa klik dan melakukan pelacakan untuk menghentikan penyebaran Coronavirus Disease (COVID-19).</p>
          </div>
          <div class="col-sm-3 ">
            <h4>Menu</h4>
            <ul>
              <li><a href="">Home</a></li>
              <li><a href="#">Tentang</a></li>
              <li><a href="#">Kontak</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h4>Kategori</h4>
            <ul>
              <li><a href="#">Vaksinasi Covid-19</a></li>
              <li><a href="#">Penanganan Kesehatan</a></li>
              <li><a href="#">Pemulihan Ekonomi</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h4>Kontak</h4>
            <ul>
              <li><i class="fa fa-envelope pe-1"></i><a href="mailto:johanpbrc@gmail.com"> johanpbrc@gmail.com</a></li>
              <li><i class="fas fa-phone pe-1"></i><a href="phoneto:+62-821-2522-0349"> +62-821-2522-0349</a></li>
              <li><i class="fas fa-map-marker-alt px-1"></i>Jl. Gunung Tugel. Tombol. Tongas. Tongaskulon. No.321</li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- End of Footer -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Swipper -->
    <script src="js/swiper-bundle.min.js"></script>

    <script>
      var myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
          myModal.show();

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

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>