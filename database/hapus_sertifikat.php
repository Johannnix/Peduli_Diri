<?php 

  include 'config.php';
  $no = $_GET['no'];

  $i = mysqli_query($conn, "SELECT * FROM upload WHERE no ='$no'");
  $u = mysqli_fetch_array($i);
  if(is_file("../img/upload/".$u['image'])) unlink("../img/upload/".$u['image']);
  $sql = "DELETE FROM upload WHERE no='$no'";

  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/sertifikat.php?sukses=Data Berhasil Dihapus.");
  }else{
    header("Location: ../pages/sertifikat.php?gagal=Data Tidak Berhasil Dihapus.");
  }

?>