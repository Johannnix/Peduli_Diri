<?php 

  include 'config.php';
  $no = $_GET['no'];

  $sql = "DELETE FROM upload WHERE no='$no'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/sertifikat.php?sukses=Data Berhasil Dihapus.");
  }else{
    header("Location: ../pages/sertifikat.php?gagal=Data Tidak Berhasil Dihapus.");
  }

?>