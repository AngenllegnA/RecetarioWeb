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

$nombre = $_POST['nombreArchivo'];
$archivo = $_FILES['archivo'];

#Categoria y tipo
$tipo = $archivo['type'];
$categoria = pathinfo($archivo['name'], PATHINFO_EXTENSION);
//$categoria = explode('.', $archivo['name'])[1];

#tipo de receta
$tipo_receta = $_POST['tipo_receta'];

#validaciones
$validacion = TipoArchivo($tipo, $categoria);
if (!$validacion['valido']) {
    echo "<script>
        alert('Error de validación: " . addslashes($validacion['mensaje']) . "');
        window.location.href = '" . $tipo_receta . ".php?insertar=error';
    </script>";
    exit();
}

$tamano_maximo = 20 * 1024 * 1024; // 20 MB

if ($_FILES['archivo']['size'] > $tamano_maximo) {
    echo "<script>
        alert('El archivo excede el tamaño máximo permitido (20 MB).');
         window.location.href = '" . $tipo_receta . ".php?insertar=error';
    </script>";
    exit();
}

#archivo
$tmp_name = $archivo['tmp_name'];
$contenido_archivo = file_get_contents($tmp_name);
//$contenido_archivo = file_get_contents($tmp_name);
//$archivoBLOB = addslashes($contenido_archivo);

#conexion a la bd
$conexion_recetas = conexion_recetas();

$query = insertar($conexion_recetas, $nombre, $categoria, $contenido_archivo, $tipo_receta, $tipo, $usuario_id);

if ($query) {
    header("location:".$tipo_receta.".php?insertar=success");
} else {
    header("location:".$tipo_receta.".php?insertar=error");
}

?>