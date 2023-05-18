    
  <?php
  // Inicia la sesión o reanuda la sesión existente
  session_start();

  // Verifica si el usuario ya está autenticado
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $welcome_message = "Bienvenido, $username";
  } else {
    header('Location:  html/login.php');
  }

  // Verifica si se ha enviado una solicitud de cierre de sesión
  if (isset($_GET['logout'])) {
    // Cierra la sesión actual
    session_destroy();
    // Redirige a la página de inicio de sesión
    header('Location:  html/login.php');
    exit;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
  <link href="https://fonts.cdnfonts.com/css/pok" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
</head>
<body>
  <div class=" titulo">
      <div class="row">
        <div class= "col Pokedex">
          <h1>Pokedex</h1>
        </div>
        <div class="col Cerrar">
          
        <?php if (isset($_SESSION['username'])): ?>
          <p><a class="btn-light btn" href="?logout">Cerrar sesión</a></p>
        <?php else: ?>
          <p><a href="html/login.php">Iniciar sesión</a></p>
        <?php endif; ?>
        </div>
      </div>
      <div class="">
      </div>
    </div>
  <div class=" pokemones shadow p-31">
    <h5><?php echo $welcome_message; ?></h5>

    <div class="row" id="lista">
    </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body" id="modalBody">
          
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
  <script src="javascript/index.js"></script>
</body>
</html>
