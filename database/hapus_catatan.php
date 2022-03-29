<?php 

  include 'config.php';
  $no = $_GET['no'];

  $sql = "DELETE FROM catatan WHERE no='$no'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/riwayat_perjalanan.php?sukses=Data Berhasil Dihapus.");
  }else{
    header("Location: ../pages/riwayat_perjalanan.php?gagal=Data Tidak Berhasil Dihapus.");
  }

?>