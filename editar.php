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

$id = $_GET['id'];
$tipo_receta = $_GET['tipo_receta'];

$conexion_recetas = conexion_recetas();
$datos = datos($conexion_recetas, $id, $usuario_id, $es_admin);

// Si no encuentra los datos, redirigir
if (!$datos) {
    header('location:'.$tipo_receta.'.php?error=no_encontrado');
    exit;
}

$nombre = $datos['nombre']; 
$categoria = $datos['categoria'];
$tipo = $datos['tipo'];
$archivo = $datos['archivo'];

$titulo = $nombre.'.'.$categoria;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>editar</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style_recetario.css">
</head>
<body>
	<!-- Encabezado -->
	<div class="titulo container-fluid py-5">
      <div class="container text-white">
        <h1 class="display-2"><b>Editar archivo</b></h1>
      </div>
    </div>

    <div class="container">
		<!-- Formulario -->
		<form class="m-auto w-50 mt-4 mb-4" method="POST" enctype="multipart/form-data" action="modificar.php">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<h3 class="text-center mt-4"><?php echo $titulo;?></h3>
			<div class="mt-4 mb-4">
				<label class="form-label">Nombre del archivo</label>
				<input class="form-control form-control-sm" type="text" name="nombreArchivo" value="<?php echo $nombre; ?>">
			</div>

			<div class="mt-4 mb-4">
				<label class="form-label">Selecciona un archivo</label>
				<input class="form-control form-control-sm" type="file" name="archivo">
			</div>

			<input type="hidden" name="tipo_receta" value="<?php echo $tipo_receta; ?>">
			<button class="btn btn-secondary">Actualizar archivo</button>
			<a class="btn btn-warning" href="<?php echo $tipo_receta ?>.php">Regresar</a>
		</form>

		<div class="m-auto w-75 mt-4 text-center">
			<?php
			$valor = '';
			if($categoria == 'pdf'){
    			$valor = "<iframe class='w-100' height='500' src='data:application/pdf;base64,".base64_encode($archivo)."'></iframe>";
			} elseif($categoria == 'png' || $categoria == 'jpg' || $categoria == 'jpeg'){
				$valor = "<img class='img-fluid mx-auto d-block' style='max-height:500px; object-fit:contain;' src='data:image/".$tipo.";base64,".base64_encode($archivo)."'>";
			}
			echo $valor;
			?>
		</div>
	</div>

	<footer>
        <p><b>&copy; 2025 UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</b></p>  
    </footer>
<script src="js/bootstrap.min.js"></script>
</body>
</html>