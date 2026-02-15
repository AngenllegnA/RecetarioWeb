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

#captura de datos
$tipo_r = $_POST['tipo_receta'];
$id = $_POST['id'];
$nombre = $_POST['nombreArchivo'];
$archivo = $_FILES['archivo'];

#conexion a la bd
$conexion_recetas = conexion_recetas();
$datos = datos($conexion_recetas, $id, $usuario_id, $es_admin);

// Verificar que el usuario tiene permisos para editar
if (!$datos) {
    header("location:".$tipo_r.".php?error=sin_permisos");
    exit;
}

$nombreA = $datos['nombre'];

if(($archivo['size']==0 && $nombre=='') || ($archivo['size']==0 && $nombre=="$nombreA")){
    header("location:editar.php?id=$id&tipo_receta=$tipo_r");
}

if(($archivo['size']==0 && $nombre!='') || ($archivo['size']==0 && $nombre!="$nombreA")){
    $query = editarnombre($conexion_recetas, $id, $nombre, $usuario_id, $es_admin);
    header("location:editar.php?id=$id&tipo_receta=$tipo_r&editar=success");
}

#Categoria y tipo
$tipo = $archivo['type'];
$categoria = explode('.', $archivo['name'])[1];
$tipo_receta = $tipo_r;

#archivo
$tmp_name = $archivo['tmp_name'];
$contenido_archivo = file_get_contents($tmp_name);
$archivoBLOB = $contenido_archivo;
//$archivoBLOB = addslashes($contenido_archivo);

if (($archivo['size']>0 && $nombre=='') || ($archivo['size']>0 && $nombre=="$nombreA")) {
    $query = editararchivo($conexion_recetas, $id, $categoria, $tipo, $tipo_receta, $archivoBLOB, $usuario_id, $es_admin);
    header("location:editar.php?id=$id&tipo_receta=$tipo_receta&editar=success");
}

if (($archivo['size']>0 && $nombre!='') || ($archivo['size']>0 && $nombre!="$nombreA")) {
    $query = editar($conexion_recetas, $id, $nombre, $categoria, $tipo, $tipo_receta, $archivoBLOB, $usuario_id, $es_admin);
    header("location:editar.php?id=$id&tipo_receta=$tipo_receta&editar=success");
}
?>