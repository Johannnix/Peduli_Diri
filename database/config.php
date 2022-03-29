<?php

  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "peduli_diri";

  $conn = mysqli_connect($server, $username, $password, $database);

  if (!$conn) {
    exit('Connection Failed.');
  }

?>