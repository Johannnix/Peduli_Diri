<?php 

  include 'config.php';
  $no = $_POST['nomor'];
  $tanggal = $_POST['tanggal'];
  $jam = $_POST['jam'];
  $lokasi = $_POST['lokasi'];
  $suhu = $_POST['suhu'];

  $sql = "UPDATE catatan SET tanggal='$tanggal', jam='$jam', lokasi='$lokasi', suhu='$suhu' WHERE no='$no'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/riwayat_perjalanan.php?sukses=Data Berhasil Diubah.");
  }else{
    header("Location: ../pages/riwayat_perjalanan.php?gagal=Data Tidak Berhasil Diubah.");
  }

?>