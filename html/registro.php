<?php
// Incluye el archivo de conexión a la base de datos
include '../DB/config.php';

// Inicia la sesión o reanuda la sesión existente
session_start();

// Verifica si el usuario ya está autenticado y redirige a una página de bienvenida
if (isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

// Verifica si el formulario de registro fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtiene los datos del formulario
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Verifica si las contraseñas coinciden
  if ($password !== $confirm_password) {
    echo "Las contraseñas no coinciden";
    header('Location: registro.php?error=1');
  } else {
    // Verifica si el usuario ya existe en la base de datos
    $existing_user_query = "SELECT * FROM users WHERE username = '$username'";
    $existing_user_result = $conn->query($existing_user_query);
    if ($existing_user_result->num_rows > 0) {
      echo "El nombre de usuario ya está en uso";
      header('Location: registro.php?error=2');
      exit;
    }

    // Encripta la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserta los datos del usuario en la base de datos
    $insert_user_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if ($conn->query($insert_user_query) === TRUE) {
      echo "Registro exitoso";

      // Inicia sesión para el nuevo usuario registrado
      $_SESSION['username'] = $username;
      header('Location: ../index.php');
      exit;
    } else {
      echo "Error: " . $insert_user_query . "<br>" . $conn->error;
    }
  }

  // Cierra la conexión a la base de datos
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/poke.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/registro.css">
    <title>Registro</title>
</head>
<body>
    <div class="container shadow-lg mb-5">
        <div class="pokeimagen">
            <img src="../imagenes/poke.png" class="img-fluid w-25" alt="">
        </div>
        <h2>Registro</h2>
        <?php
            // Mostrar una alerta si se recibió un parámetro de error en la URL
            if(isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<p style="color: red;">Las contraseñas no coinciden</p>';
            }
        ?>
        <?php
            // Mostrar una alerta si se recibió un parámetro de error en la URL
            if(isset($_GET['error']) && $_GET['error'] == 2) {
                echo '<p style="color: red;">El usuario ya se encuentra registrado</p>';
            }
        ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="" class="form-label">Nombre Usuario</label>
            <input type="text" class="form-control" name="username" id="" required >
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Correo electronico</label>
            <input type="email" class="form-control" name="email" id="" required>
            <small id="emailHelpId" class="form-text text-muted"></small>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="" placeholder="" required>
          </div>
          <div class="mb-3">
              <label for="" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="confirm_password" id="" placeholder="" required>
            </div>
          <div>
              <button type="submit" value="Registrar" class="w-100 btn btn-danger">Registrar</button>
          </div>
      </form>
      <a href="login.php"> Iniciar Sesión</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
