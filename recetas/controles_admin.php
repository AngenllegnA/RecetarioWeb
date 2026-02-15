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
  <link rel="stylesheet" href="css/font-awesome.min.css">
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
        <a class="nav-link" href="close.php">Cerrar sesión</a>
      </div>
    </div>
  </div>
</nav>
<!-- Fin navbar -->

<!-- Encabezado -->
<div class="titulo4 container-fluid py-5">
  <div class="container text-white">
    <h1 class="display-2"><b>Gestion de Usuarios</b></h1>
      <p class="lead">Actualizar o Eliminar Usuarios</p>
  </div>
</div>
<!-- Fin encabezado -->

<div class="container">

    <!-- Tabla -->
    <table class="table table-sm mt-2">
      <thead>
        <th>ID</th>
        <th>Correo Electronico</th>
        <th>Tipo de usuario</th>
        <th>Acciones</th>
      </thead>

      <tbody>
        <?php 
          $query = listar_usuarios($conexion_recetas, $usuario_id);
          $contador = 0;

          while ($datos = $query->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
            $id = $datos['id'];
            $correo = $datos['usuario'];
            $t_usuario = $datos['tipo_usuario'];

        ?>
        <tr>
          <form action="modificar_usuario.php" method="POST">

          <td>
          <i class="fa fa-user-o icons" aria-hidden="false"></i> 
          <?php echo $contador; ?>   
          </td>
          <td><?php echo $correo; ?></td>
          <td>
            <select class="form-control" name="rol">
              <option value="<?php echo $t_usuario; ?>"><?php echo $t_usuario; ?></option>
              <option value="usuario">Usuario</option>
              <option value="administrador">Administrador</option>
            </select>
          </td>
          <td>
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <button type="submit" class="btn btn-primary btn-sm">Guardar cambios</button>
            <a class="btn btn-danger btn-sm" href="eliminar_usuario.php?id=<?php echo $id?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
          </td>
          </form>
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