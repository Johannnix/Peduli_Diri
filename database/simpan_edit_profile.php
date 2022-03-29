<?php 

  include 'config.php';
  $id = $_POST['id'];
  $nik = $_POST['nik'];
  $nama = $_POST['nama'];
  $jenkel = $_POST['jenkel'];
  $alamat = $_POST['alamat'];

  $sql = "UPDATE pengguna SET nik='$nik', nama='$nama', jenkel='$jenkel', alamat='$alamat' WHERE id='$id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("Location: ../pages/profile.php?sukses=Data Berhasil Diubah.");
  }else{
    header("Location: ../pages/profile.php?gagal=Data Tidak Berhasil Diubah.");
  }

?>