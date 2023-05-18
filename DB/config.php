<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "users";

  // Crea la conexión
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Verifica si hay errores en la conexión
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>
