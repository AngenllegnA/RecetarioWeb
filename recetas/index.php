<?php 
session_start();
require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$user = iniciarsesion('usuarios', $conexion);
$usuario_id = obtener_usuario_id($conexion);
$es_admin = es_administrador($conexion);  
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style_recetario.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
	<title>Inicio - Recetario</title>
</head>
<body>

<!-- Inicio navbar -->
<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Recetario</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="desayuno.php">Desayunos</a>
        <a class="nav-link" href="comida.php">Comidas</a>
        <a class="nav-link" href="cena.php">Cenas</a>
        <a class="nav-link" href="postre.php">Postres</a>
        <?php if ($es_admin): ?>
        <a class="nav-link" href="controles_admin.php">Gestionar Usuarios</a>
        <?php endif; ?>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="close.php">Cerrar sesión</a>
      </div>
    </div>
  </div>
</nav>
<!-- Fin navbar -->

<!-- Hero Section -->
<section class="hero" id="inicio">
    <div class="hero-content">
        <h2>RECETARIO WEB</h2>
        <p>Guarda tus recetas favoritas y consultalas a donde vayas</p>
    </div>
</section>

<!-- Inicio container -->
<div class="container">

    <!-- Primer renglon -->
    <div class="video-introductorio row mt-5">
      <div class="col">
        <video controls width="640" height="520" class="video d-block mx-auto mt-5 mb-5">
          <source src="video/VideoIntroductorio.mp4" type="video/mp4">
        </video>
      </div>
    </div>
    <!-- Fin de primer renglon -->

    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Información del usuario</h3>
                    <p class="card-text">
                        <strong>Correo:</strong> <?php echo $user['usuario']; ?><br>
                        <strong>Tipo:</strong> <?php echo $user['tipo_usuario']; ?><br>
                        <strong>Acceso:</strong> 
                        <?php 
                        if ($user['tipo_usuario'] == 'administrador') {
                            echo 'Puedes ver y gestionar todas las recetas del sistema';
                        } else {
                            echo 'Puedes ver y gestionar solo tus recetas';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>

    <!-- Segundo renglon -->
    <div class="row mt-5">
      <div class="col-6 mt-4 mb-4">

        <div class="card" style="width: 35rem;">
        <img src="img/desayuno.jpg" class="imagen card-img-top d-block mx-auto mt-5">
        <div class="card-body">
          <h3 class="titulo-carta card-title">Desayuno</h3>
          <p class="card-text">Empieza tu día con energía con opciones frescas y nutritiva.
          Para mantenerte activo desde temprano.</p>
          <a href="desayuno.php" class="btn btn-warning d-block mx-auto">Ir a desayuno</a>
        </div>
        </div>

      </div>

      <div class="col-6 mt-4 mb-4">

        <div class="card" style="width: 35rem;">
        <img src="img/comida.jpg" class="imagen card-img-top d-block mx-auto mt-5">
        <div class="card-body">
          <h3 class="titulo-carta card-title">Comida</h3>
          <p class="card-text">Un momento para compartir, difrutar y recargar fuerzas
           mitad del día con opciones completas y balanceadas.</p>
          <a href="desayuno.php" class="btn btn-warning d-block mx-auto">Ir a comida</a>
        </div>
        </div>

      </div>
    </div>
    <!-- Fin segundo renglon -->

    <!-- Tercer renglon -->
    <div class="row mt-5">
      <!--<div class="col-4">
        <img src="img/comida.jpg" class="portada d-block mx-auto">
      </div>-->
      <div class="col-6 mt-4 mb-4">

        <div class="card" style="width: 35rem;">
        <img src="img/cena.jpg" class="imagen card-img-top d-block mx-auto mt-5">
        <div class="card-body">
          <h3 class="titulo-carta card-title">Cena</h3>
          <p class="card-text">La oportunidad de relajarte y cerrar la jornada con preparaciones ligeras
          y satisfactorias que brindad tranqilidad.</p>
          <a href="cena.php" class="btn btn-warning d-block mx-auto">Ir a cena</a>
        </div>
        </div>

      </div>
      <div class="col-6 mt-4 mb-4">
        <!--<h3>Comida</h3>
        <p>Un momento para compartir, difrutar y recargar fuerzas<br>
         a mitad del día con opciones completas y balanceadas.</p>
        <button class="btn btn-warning align-self-start" href="comida.php">Ir a comidas</button>-->
        <div class="card" style="width: 35rem;">
        <img src="img/postre.jpg" class="imagen card-img-top d-block mx-auto mt-5">
        <div class="card-body">
          <h3 class="titulo-carta card-title">Postres</h3>
          <p class="card-text">Un detalle dulce para consentirte, ideal para acompañar cualquier 
          cualquier ocasión y disfrutar de un momento especial.</p>
          <a href="postre.php" class="btn btn-warning d-block mx-auto ">Ir a postres</a>
        </div>
        </div>

      </div>
    </div>
    <!-- Fin tercer renglon -->

</div>
<!-- Fin container -->

<!--Pie de pagina-->
<footer>
    <p><b>&copy; 2025 UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</b></p>  
</footer>
<!-- Fin de pie de pagina -->

<script src="js/bootstrap.min.js"></script>
</body>
</html>