<?php 

  include 'config.php';

  session_start();

  $id = $_SESSION['id'];
  $tanggal = $_POST['tanggal'];
  $jam = $_POST['jam'];
  $lokasi = $_POST['lokasi'];
  $suhu = $_POST['suhu'];

  $sql = "INSERT INTO catatan SET id='$id', tanggal='$tanggal', jam='$jam', lokasi='$lokasi', suhu='$suhu'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/riwayat_perjalanan.php?sukses=Data Berhasil Disimpan.");
  }else{
    header("Location: ../pages/tulis_catatan.php?gagal=Data Tidak Berhasil Disimpan.");
  }

?>