<?php
        // Incluye el archivo de conexión a la base de datos
        include '../DB/config.php';
        unset($message); 
        // Inicia la sesión o reanuda la sesión existente
        session_start();
        // Verifica si el usuario ya está logeado y redirige a una página de bienvenida
        if (isset($_SESSION['username'])) {
            header('Location: ../index.php');
            exit;
        }
        // Verifica si el formulario de inicio de sesión fue enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtiene los datos del formulario
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Busca al usuario en la base de datos
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // Obtiene los datos del usuario
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            // Verifica si la contraseña es correcta
            if (password_verify($password, $stored_password)) {
                // Inicia sesión para el usuario autenticado
                $_SESSION['username'] = $username;
                //retorna a la pagina donde se muestran los pokemones
                header('Location: ../index.php');
                exit;
            } else {
                //retorna el error 2 que Contraseña incorrecta
                header('Location: login.php?error=2');
            }
            } else {
                //Retorna el  error 1 que es usuario no encontrado
                header('Location: login.php?error=1');
            }
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
    <link rel="stylesheet" href="../css/login.css">
    <title>Inicio Sesión</title>
</head>
<body>
    <div class="container shadow-lg">
        <div class="pokeimagen">
            <img src="../imagenes/poke.png" class="img-fluid w-25" alt="">
        </div>
        <h1>Inicio Sesión</h1>
        <?php
            // Mostrar una alerta si se recibió un parámetro de error en la URL
            if(isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<p style="color: red;">Usuario no encontrado</p>';
            }
            if(isset($_GET['error']) && $_GET['error'] == 2) {
                echo '<p style="color: red;">Contraseña incorrecta</p>';
            }
        ?>
        <form action="" method="post">
            <div class="mb-3">
            <label for="" class="form-label">Usuario</label>
            <input type="text" class="form-control" name="username" aria-describedby="emailHelpId">
            <small id="emailHelpId" class="form-text text-muted"></small>
            </div>
            <div class="mb-3">
            <label for="" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="" placeholder="">
            </div>
            <div>
                <button type="submit" class="w-100 btn btn-danger">Iniciar</button>
            </div>
        </form>
        <a href="registro.php">Registrate</a>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
