<?php 
session_start();
require 'admin/config.php';
require 'functions.php';
require 'funciones.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$user = iniciarsesion('usuarios', $conexion);
$usuario_id = obtener_usuario_id($conexion);
$es_admin = es_administrador($conexion);

// Conexión para recetas
$conexion_recetas = conexion_recetas();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style_recetario.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <title>Desayunos</title>
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
        <!--<span class="navbar-text me-3">
          Hola, <?php// echo $user['usuario']; ?>
        </span>-->
        <a class="nav-link" href="close.php">Cerrar sesión</a>
      </div>
    </div>
  </div>
</nav>
<!-- Fin navbar -->

<!-- Encabezado -->
<div class="titulo0 container-fluid py-5">
  <div class="container text-white">
    <h1 class="display-2"><b>TUS DESAYUNOS</b></h1>
    <?php if ($es_admin): ?>
      <p class="lead" style="color: #fff;">Vista de administrador</p>
    <?php endif; ?>
    <p>Empieza tu día con energía y sabor.</p>
  </div>
</div>
<!-- Fin encabezado -->

<div class="container">
    <!-- Formulario -->
    <form class="m-auto w-50 mt-4 mb-4" method="POST" enctype="multipart/form-data" action="insertar.php">
      <div class="mt-4 mb-4">
        <label class="form-label"><b>Nombre de la receta</b></label>
        <input class="form-control" type="text" name="nombreArchivo" required>
      </div>

      <div class="mt-4 mb-4">
        <label class="form-label"><b>Seleccione el archivo</b></label>
        <input class="form-control" type="file" name="archivo" required>
      </div>

      <div>
        <p style="color: gray;"> <b>Formatos permitidos:</b> PDF, DOCX, JPG, JPEG, PNG, MP4. <b>Tamaño máximo:</b> 20 MB. </p>
      </div>

      <input type="hidden" name="tipo_receta" value="desayuno">
      <button class="btn btn-secondary">Subir archivo</button>
    </form>
    <!-- Fin formulario -->

    <!-- Tabla -->
    <table class="table table-sm mt-2">
      <thead>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoria</th>
        <th>Archivo</th>
        <th>Tipo de receta</th>
        <?php if ($es_admin): ?>
          <th>Usuario</th>
        <?php endif; ?>
        <th>Acciones</th>
      </thead>

      <tbody>
        <?php 
          $tipo_comida = 'desayuno';
          $query = listar($conexion_recetas, $tipo_comida, $usuario_id, $es_admin);
          $contador = 0;

          while ($datos = $query->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
            $id = $datos['id'];
            $nombre = $datos['nombre'];
            $categoria = $datos['categoria'];
            $archivo = $datos['archivo'];
            $tipo_receta = $datos['tipo_receta'];
            $tipo = $datos['tipo'];

            $valor = "";
            if($categoria == 'png' || $categoria == 'jpg' || $categoria == 'jpeg'){
              $valor = "<img src='img/imagen.png' width='30'>";
            } elseif($categoria == 'pdf'){
              $valor = "<img src='img/pdf.png' width='30'>";
            } elseif($categoria == 'xls' || $categoria == 'xlsx'){
              $valor = "<img src='img/xls.png' width='30'>";
            } elseif($categoria == 'mp3'){
              $valor = "<img src='img/mp3.png' width='30'>";
            } elseif($categoria == 'mp4'){
              $valor = "<img src='img/mp4.png' width='30'>";
            } else {
              $valor = "<img src='img/desconocido.png' width='30'>";
            }
        ?>
        <tr>
          <td><?php echo $contador; ?></td>
          <td><?php echo $nombre; ?></td>
          <td><?php echo $categoria; ?></td>
          <td><a class="btn-download" href="descargar.php?id=<?php echo $id?>"><?php echo $valor; ?> descargar</a></td>
          <td><?php echo $tipo_receta; ?></td>
          <?php if ($es_admin): ?>
            <td>ID: <?php echo $datos['usuario_id']; ?></td>
          <?php endif; ?>
          <td>
            <a class="btn btn-warning btn-sm" href="ver.php?id=<?php echo $id?>">Ver</a>
            <a class="btn btn-primary btn-sm" href="editar.php?id=<?php echo $id?>&tipo_receta=desayuno">Editar</a>  
            <a class="btn btn-danger btn-sm" href="eliminar.php?id=<?php echo $id?>&tipo_receta=desayuno" onclick="return confirm('¿Estás seguro de eliminar esta receta?')">Eliminar</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <!-- Fin tabla -->
</div>

<!--Pie de pagina-->
<footer>
    <p><b>&copy; 2025 UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</b></p>  
</footer>

<script src="js/bootstrap.min.js"></script>
</body>
</html>